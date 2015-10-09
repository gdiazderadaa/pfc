<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Objeto;

/**
 * ObjetoSearch represents the model behind the search form about `app\models\Objeto`.
 */
class ObjetoSearch extends Objeto
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'espacio_id', 'tipo_id'], 'integer'],
            [['codigo', 'nombre','fecha_compra'], 'safe'],
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
        $query = Objeto::find();

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
            'espacio_id' => $this->espacio_id,
            'tipo_id' => $this->tipo_id,
            'fecha_compra' => $this->fecha_compra
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
