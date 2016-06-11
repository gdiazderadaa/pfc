<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParteElementoHardware;

/**
 * ParteElementoHardwareSearch represents the model behind the search form about `app\models\ParteElementoHardware`.
 */
class ParteElementoHardwareSearch extends ParteElementoHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['elemento_hardware_id', 'parte_elemento_hardware_id', 'id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ParteElementoHardware::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'elemento_hardware_id' => $this->elemento_hardware_id,
            'parte_elemento_hardware_id' => $this->parte_elemento_hardware_id,
            'id' => $this->id,
        ]);

        return $dataProvider;
    }
}
