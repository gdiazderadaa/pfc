<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PlantaEdificio;

/**
 * PlantaEdificioSearch represents the model behind the search form about `app\models\PlantaEdificio`.
 */
class PlantaEdificioSearch extends PlantaEdificio
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id'], 'integer'],
            [['nombre', 'imagen', 'imagen_servidor'], 'safe'],
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
        $query = PlantaEdificio::find();

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
            'edificio_id' => $this->edificio_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'imagen', $this->imagen])
            ->andFilterWhere(['like', 'imagen_servidor', $this->imagen_servidor]);

        return $dataProvider;
    }
}
