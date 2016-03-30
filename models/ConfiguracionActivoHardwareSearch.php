<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ConfiguracionActivoHardware;

/**
 * ConfiguracionActivoHardwareSearch represents the model behind the search form about `app\models\ConfiguracionActivoHardware`.
 */
class ConfiguracionActivoHardwareSearch extends ConfiguracionActivoHardware
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_hardware_id', 'activo_software_id'], 'integer'],
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
        $query = ConfiguracionActivoHardware::find();

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
            'activo_hardware_id' => $this->activo_hardware_id,
            'activo_software_id' => $this->activo_software_id,
        ]);

        return $dataProvider;
    }
}
