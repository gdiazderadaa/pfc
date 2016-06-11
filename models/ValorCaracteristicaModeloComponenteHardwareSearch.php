<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ValorCaracteristicaModeloComponenteHardware;

/**
 * ValorCaracteristicaModeloComponenteHardwareSearch represents the model behind the search form about `app\models\ValorCaracteristicaModeloComponenteHardware`.
 */
class ValorCaracteristicaModeloComponenteHardwareSearch extends ValorCaracteristicaModeloComponenteHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'caracteristica_id', 'modelo_componente_hardware_id'], 'integer'],
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
        $query = ValorCaracteristicaModeloComponenteHardware::find();

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
            'caracteristica_id' => $this->caracteristica_id,
            'modelo_componente_hardware_id' => $this->modelo_componente_hardware_id,
        ]);

        $query->andFilterWhere(['like', 'valor', $this->valor]);

        return $dataProvider;
    }
}
