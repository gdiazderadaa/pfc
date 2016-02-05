<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivoInfraestructura;

/**
 * ActivoInfraestructuraSearch represents the model behind the search form about `app\models\ActivoInfraestructura`.
 */
class ActivoInfraestructuraSearch extends ActivoInfraestructura
{
        
    public function attributes()
    {
        // add related fields to searchable attributes
      return array_merge(parent::attributes(), [/*'activo_inventariable.codigo',
                                                'activo_inventariable.nombre',
                                                'activo_inventariable.fecha_compra',
                                                'activo_inventariable.precio_compra',*/
                                                /*'espacio.nombre',*/
                                                'subcategoriaActivoInfraestructura.nombre']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'subcategoria_activo_infraestructura_id','espacio_id'], 'safe'],
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
        $query = ActivoInfraestructura::find();

        // $query->joinWith(['subcategoriaActivoInfraestructura']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $dataProvider->sort->attributes['espacio_id'] = [
        //     'asc' => ['espacio.nombre' => SORT_ASC],
        //     'desc' => ['espacio.nombre' => SORT_DESC],
        // ];
        
        // $dataProvider->sort->attributes['subcategoria_activo_infraestructura_id'] = [
        //     'asc' => ['subcategoria_activo_infraestructura.nombre' => SORT_ASC],
        //     'desc' => ['subcategoria_activo_infraestructura.nombre' => SORT_DESC],
        // ];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // $query->andFilterWhere(['activo_inventariable_id' => $this->activo_inventariable_id])
             $query->andFilterWhere(['like', 'subcategoria_activo_infraestructura.nombre' => $this->subcategoria_activo_infraestructura_id])
             ->andFilterWhere(['like', 'espacio_id', $this->espacio_id]);

        return $dataProvider;
    }
}
