<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Incidencia;

/**
 * IncidenciaSearch represents the model behind the search form about `app\models\Incidencia`.
 */
class IncidenciaSearch extends Incidencia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tipo_id', 'impacto_id', 'urgencia_id', 'tecnico_id', 'objeto_id', 'estado_id', 'creador_id'], 'integer'],
            [['descripcion_breve', 'descripcion', 'fecha_creacion', 'fecha_fin'], 'safe'],
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
        $query = Incidencia::find();

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
            'tipo_id' => $this->tipo_id,
            'impacto_id' => $this->impacto_id,
            'urgencia_id' => $this->urgencia_id,
            'tecnico_id' => $this->tecnico_id,
            'objeto_id' => $this->objeto_id,
            'fecha_creacion' => $this->fecha_creacion,
            'fecha_fin' => $this->fecha_fin,
            'estado_id' => $this->estado_id,
            'creador_id' => $this->creador_id,
        ]);

        $query->andFilterWhere(['like', 'descripcion_breve', $this->descripcion_breve])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
