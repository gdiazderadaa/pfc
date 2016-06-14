<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "modelo_componente_hardware".
 *
 * @property string $id
 * @property string $marca
 * @property string $modelo
 * @property string $categoria_id
 * @property string $cantidad
 * @property integer $inventario 
 *
 * @property ComponenteHardware[] $componentesHardware
 * @property Categoria $categoria
 */
class ModeloComponenteHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modelo_componente_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Component Model');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Component Models');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['marca', 'modelo', 'categoria_id', /*'cantidad',*/'inventario'], 'required'],
            [['categoria_id', 'cantidad','inventario'], 'integer'],
            [['marca'], 'string', 'max' => 128],
            [['modelo'], 'string', 'max' => 256],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['modelo'], 'unique', 'targetAttribute' => ['marca','modelo']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'marca' => Yii::t('app', 'Manufacturer'),
            'modelo' => Yii::t('app', 'Model'),
            'categoria_id' => Yii::t('app', 'Category'),
            'cantidad' => Yii::t('app', 'Quantity'),
            'inventario' => Yii::t('app', 'Inventory'),
        ];
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentesHardware()
    {
        return $this->hasMany(ComponenteHardware::className(), ['modelo_componente_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        $categorias = Categoria::find()->asArray()->all();
        return ArrayHelper::map($categorias, 'id','nombre');
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasModeloComponenteHardware()
    {
        return $this->hasMany(ValorCaracteristicaModeloComponenteHardware::className(), ['modelo_componente_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['id' => 'caracteristica_id'])->viaTable('valor_caracteristica_elemento_hardware', ['elemento_hardware_id' => 'id']);
    }
    
    /**
    * @return string
    */   
    public function getTipo()
    {
        return "Componente";
    }
    
    /**
    * @return string
    */   
    public function getNombre()
    {
        return $this->marca . ' ' .$this->modelo;
    }
    
    /**
    * @return array
    */  
    public static function getModelosByCategoria($categoriaId, $inventario) 
	{	
        $models = ModeloComponenteHardware::find()->where(['inventario' => $inventario, 'categoria_id'=>$categoriaId])->all();
        return ArrayHelper::toArray($models, [
            ModeloComponenteHardware::classname() => [
                'id',
                'name' => 'nombre'
            ],
        ]);
    }
    
    /**
     * @return array
     */
    public static function getModelosByCategoria2()
    {
    	$models = ModeloComponenteHardware::find()->where(['categoria_id'=>$categoriaId])->all();
    	return ArrayHelper::toArray($models, [
    			ModeloComponenteHardware::classname() => [
    					'id',
    					'name' => 'nombre'
    			],
    	]);
    }
    
    public function getComponentesHardwareDataProvider($id)
    {
    	$query = ComponenteHardware::find()
    				->andFilterWhere(['modelo_componente_hardware_id' => $id]);
    	$componentesHardwareDataProvider = new yii\data\ActiveDataProvider([
    			'query' => $query,
    	]);

        return $componentesHardwareDataProvider;
    }
    
    public function getCosteTotal()
    {
        return $this->getComponentesHardware()->sum('precio_compra');
    }
    
    public function getTotalEnGarantia()
    {
        $modelos = $this->getComponentesHardware()->all();
        $cuenta = 0;
        foreach ($modelos as $modelo) {
            if (!$modelo->EnGarantia && $modelo->meses_garantia != null) {
                $cuenta++;
            }
        }

        return $cuenta;
    }
    
    public function getTotalGarantiaExpirada()
    {
        $modelos = $this->getComponentesHardware()->all();
        $cuenta = 0;
        foreach ($modelos as $modelo) {
            if ($modelo->garantiaExpirada) {
                $cuenta++;
            }
        }

        return $cuenta;
    }
   
}
