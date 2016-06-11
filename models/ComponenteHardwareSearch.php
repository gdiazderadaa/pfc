<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ComponenteHardware;

/**
 * ComponenteHardwareSearch represents the model behind the search form about `app\models\ComponenteHardware`.
 */
class ComponenteHardwareSearch extends ComponenteHardware
{
    public $marcaModeloComponenteHardware;
    public $modeloModeloComponenteHardware;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'modelo_componente_hardware_id', 'meses_garantia', 'activo_hardware_id'], 'integer'],
            [['numero_serie', 'estado', 'fecha_compra','marcaModeloComponenteHardware','modeloModeloComponenteHardware'], 'safe'],
            [['precio_compra'], 'number'],
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
        $query = ComponenteHardware::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->sort->attributes['marcaModeloComponenteHardware'] = [
            'asc' => ['modelo_componente_hardware.marca' => SORT_ASC],
            'desc' => ['modelo_componente_hardware.marca' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['modeloModeloComponenteHardware'] = [
            'asc' => ['modelo_componente_hardware.modelo' => SORT_ASC],
            'desc' => ['modelo_componente_hardware.modelo' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            /**
            * The following line will allow eager loading with country data 
            * to enable sorting by country on initial loading of the grid.
            */ 
            $query->joinWith(['modeloComponenteHardware']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'modelo_componente_hardware_id' => $this->modelo_componente_hardware_id,
            'fecha_compra' => $this->fecha_compra,
            'meses_garantia' => $this->meses_garantia,
            'precio_compra' => $this->precio_compra,
            'activo_hardware_id' => $this->activo_hardware_id,
        ]);

        $query->andFilterWhere(['like', 'numero_serie', $this->numero_serie])
            ->andFilterWhere(['like', 'estado', $this->estado]);
            
        $query->joinWith(['modeloComponenteHardware'=>function ($q) {
            $q->where('modelo_componente_hardware.marca LIKE "%' . 
                $this->marcaModeloComponenteHardware . '%"');
        }]);
        
        $query->joinWith(['modeloComponenteHardware'=>function ($q) {
            $q->where('modelo_componente_hardware.modelo LIKE "%' . 
                $this->modeloModeloComponenteHardware . '%"');
        }]);

        return $dataProvider;
    }
}
