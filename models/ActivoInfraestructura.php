<?php

namespace app\models;

use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activo_infraestructura".
 *
 * @property string $activo_inventariable_id
 * @property string $categoria_id
 *
 * @property Categoria $categoria
 * @property ActivoInventariable $activoInventariable
 */
class ActivoInfraestructura extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
{
    use ActiveRecordInheritanceTrait; 
    
    public static function extendsFrom() {
        return ActivoInventariable::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activo_infraestructura';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Infrastructure Asset');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Infrastructure Assets');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'categoria_id','codigo','nombre','fecha_compra','precio_compra','estado','espacio_id'], 'required'],
            [['activo_inventariable_id', 'categoria_id'], 'integer'],
            [['activo_inventariable_id'], 'unique'],      		
        	[['fecha_compra'], 'safe'],
        	[['precio_compra'], 'number','numberPattern' => '/^[0-9]*[.,]?[0-9]*$/'],
        	[['codigo', 'estado'], 'string', 'max' => 128],
        	[['nombre'], 'string', 'max' => 64],
        	[['codigo'], 'unique'],
        	[['precio_compra'], 'compare', 'compareValue' => 0, 'operator' => '>','type' => 'number'],
         	[['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activo_inventariable_id' => Yii::t('app', 'Asset'),
            'categoria_id' => Yii::t('app', 'Category'),
            'codigo' => Yii::t('app', 'Asset Tag'),
            'nombre' => Yii::t('app', 'Name'),
            'fecha_compra' => Yii::t('app', 'Purchase Date'),
            'precio_compra' => Yii::t('app', 'Purchase Price'),
            'espacio_id' => Yii::t('app', 'Room'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

   public function getCategorias() 
    { 
        $models = Categoria::find()->asArray()->where(['tipo' => $this->tipo])->all(); 
        return ArrayHelper::map($models,'id', 'nombre');  
    } 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasActivoInfraestructura()
    {
    	return $this->hasMany(ValorCaracteristicaActivoInventariable::className(), ['activo_inventariable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInventariable()
    {
        return $this->hasOne(ActivoInventariable::className(), ['id' => 'activo_inventariable_id']);
    }
    
    public function getTipo()
    {
    	return "Infraestructura";
    }
}
