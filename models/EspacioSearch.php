<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Espacio;

/**
 * EspacioSearch represents the model behind the search form about `app\models\Espacio`.
 */
class EspacioSearch extends Espacio
{
    
    public function attributes()
    {
        // add related fields to searchable attributes
      return array_merge(parent::attributes(), ['edificio.nombre']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre', 'numeracion','edificio_id'], 'safe'],
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
        $query = Espacio::find();
        
        $query->joinWith('edificio');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['edificio_id'] = [
            'asc' => ['edificio.nombre' => SORT_ASC],
            'desc' => ['edificio.nombre' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numeracion', $this->numeracion])
            ->andFilterWhere(['like', 'edificio.nombre', $this->edificio_id]);

        return $dataProvider;
    }
}
