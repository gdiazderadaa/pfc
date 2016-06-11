<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParteComponenteHardware;

/**
 * ParteComponenteHardwareSearch represents the model behind the search form about `app\models\ParteComponenteHardware`.
 */
class ParteComponenteHardwareSearch extends ParteComponenteHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'componente_hardware_id', 'parte_componente_hardware_id'], 'integer'],
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
        $query = ParteComponenteHardware::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'componente_hardware_id' => $this->componente_hardware_id,
            'parte_componente_hardware_id' => $this->parte_componente_hardware_id,
        ]);

        return $dataProvider;
    }
}
