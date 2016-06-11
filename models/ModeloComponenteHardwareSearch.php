<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ModeloComponenteHardware;

/**
 * ModeloComponenteHardwareSearch represents the model behind the search form about `app\models\ModeloComponenteHardware`.
 */
class ModeloComponenteHardwareSearch extends ModeloComponenteHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'cantidad', 'inventario'], 'integer'],
            [['marca', 'modelo'], 'safe'],
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
        $query = ModeloComponenteHardware::find();

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
            'categoria_id' => $this->categoria_id,
            'cantidad' => $this->cantidad,
            'inventario' => $this->inventario,
        ]);

        $query->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo]);

        return $dataProvider;
    }
}
