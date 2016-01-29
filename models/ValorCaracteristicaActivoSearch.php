<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ValorCaracteristicaActivo;

/**
 * ValorCaracteristicaActivoSearch represents the model behind the search form about `app\models\ValorCaracteristicaActivo`.
 */
class ValorCaracteristicaActivoSearch extends ValorCaracteristicaActivo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ValorCaracteristicaActivoID', 'ActivoInventariableID', 'CaracteristicaID'], 'integer'],
            [['Valor'], 'safe'],
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
        $query = ValorCaracteristicaActivo::find();

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
            'ValorCaracteristicaActivoID' => $this->ValorCaracteristicaActivoID,
            'ActivoInventariableID' => $this->ActivoInventariableID,
            'CaracteristicaID' => $this->CaracteristicaID,
        ]);

        $query->andFilterWhere(['like', 'Valor', $this->Valor]);

        return $dataProvider;
    }
}
