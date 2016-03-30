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
            [['activo_inventariable_id', 'subcategoria_activo_hardware_id'], 'integer'],
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
        $query = ActivoHardware::find();

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
            'activo_inventariable_id' => $this->activo_inventariable_id,
            'subcategoria_activo_hardware_id' => $this->subcategoria_activo_hardware_id,
        ]);

        return $dataProvider;
    }
}
