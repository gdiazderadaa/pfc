<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ActivoHardware;

/**
 * ActivoHardwareSearch represents the model behind the search form about `app\models\ActivoHardware`.
 */
class ActivoHardwareSearch extends ActivoHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoria_id'], 'safe'],
        	//[['codigo','nombre','fecha_compra','precio_compra','espacio_id'], 'safe']
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
        $query = ActivoHardware::find()->joinWith('parent')->leftJoin('espacio', '`espacio`.`id` = `activo_inventariable`.`espacio_id`')->joinWith('categoria');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['codigo'] = [
        		'asc' => ['activo_inventariable.codigo' => SORT_ASC],
        		'desc' => ['activo_inventariable.codigo' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['nombre'] = [
        		'asc' => ['activo_inventariable.nombre' => SORT_ASC],
        		'desc' => ['activo_inventariable.nombre' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['fecha_compra'] = [
        		'asc' => ['activo_inventariable.fecha_compra' => SORT_ASC],
        		'desc' => ['activo_inventariable.fecha_compra' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['precio_compra'] = [
        		'asc' => ['activo_inventariable.precio_compra' => SORT_ASC],
        		'desc' => ['activo_inventariable.precio_compra' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['espacio_id'] = [
        		'asc' => ['activo_inventariable.espacio_id' => SORT_ASC],
        		'desc' => ['activo_inventariable.espacio_id' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['categoria_id'] = [
        		'asc' => ['categoria.nombre' => SORT_ASC],
        		'desc' => ['categoria.nombre' => SORT_DESC],
        ];
        
    	if (!($this->load($params) && $this->validate())) {
	        return $dataProvider;
	    }

        $query->andFilterWhere([
            'activo_inventariable_id' => $this->activo_inventariable_id,
            'categoria_id' => $this->categoria_id,
        ])
        ->andFilterWhere(['like', 'activo_inventariable.codigo', $this->codigo])
        ->andFilterWhere(['like', 'activo_inventariable.nombre', $this->nombre])
        ->andFilterWhere(['like', 'activo_inventariable.fecha_compra', $this->parent->fecha_compra])
        ->andFilterWhere(['like', 'activo_inventariable.precio_compra', $this->precio_compra])
        ->andFilterWhere(['like', 'activo_inventariable.espacio_id', $this->espacio_id]);

        return $dataProvider;
    }
}
