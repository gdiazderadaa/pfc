<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ElementoHardware;

/**
 * ElementoHardwareSearch represents the model behind the search form about `app\models\ElementoHardware`.
 */
class ElementoHardwareSearch extends ElementoHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'activo_hardware_id','subcategoria_elemento_hardware_id'], 'integer'],
            [['numero_serie', 'marca', 'modelo', 'fecha_compra'], 'safe'],
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
        $query = ElementoHardware::find();

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
            'fecha_compra' => $this->fecha_compra,
            'precio_compra' => $this->precio_compra,
            'activo_hardware_id' => $this->activo_hardware_id,
            'subcategoria_elemento_hardware_id' => $this->activo_hardware_id,
        ]);

        $query->andFilterWhere(['like', 'numero_serie', $this->numero_serie])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo]);

        return $dataProvider;
    }
}
