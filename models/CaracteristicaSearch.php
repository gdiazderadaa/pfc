<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Caracteristica;

/**
 * CaracteristicaSearch represents the model behind the search form about `app\models\Caracteristica`.
 */
class CaracteristicaSearch extends Caracteristica
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CaracteristicaID'], 'integer'],
            [['Nombre', 'Unidades'], 'safe'],
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
        $query = Caracteristica::find();

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
            'CaracteristicaID' => $this->CaracteristicaID,
        ]);

        $query->andFilterWhere(['like', 'Nombre', $this->Nombre])
            ->andFilterWhere(['like', 'Unidades', $this->Unidades]);

        return $dataProvider;
    }
}
