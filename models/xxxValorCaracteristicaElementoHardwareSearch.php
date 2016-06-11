<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ValorCaracteristicaElementoHardware;

/**
 * ValorCaracteristicaElementoHardwareSearch represents the model behind the search form about `app\models\ValorCaracteristicaElementoHardware`.
 */
class ValorCaracteristicaElementoHardwareSearch extends ValorCaracteristicaElementoHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'caracteristica_id', 'elemento_hardware_id'], 'integer'],
            [['valor'], 'safe'],
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
        $query = ValorCaracteristicaElementoHardware::find();

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
            'id' => $this->id,
            'caracteristica_id' => $this->caracteristica_id,
            'elemento_hardware_id' => $this->elemento_hardware_id,
        ]);

        $query->andFilterWhere(['like', 'valor', $this->valor]);

        return $dataProvider;
    }
}
