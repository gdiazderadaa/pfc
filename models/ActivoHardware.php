<?php

namespace app\models;

use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activo_hardware".
 *
 * @property string $activo_inventariable_id
 * @property string $categoria_id
 *
 *
 * @property ActivoInventariable $activoInventariable
 * @property Categoria $categoria
 * @property ConfiguracionActivoHardware[] $configuracionesActivoHardware
 * @property ActivoSoftware[] $activoSoftwares
 * @property ComponenteHardware[] $componentesHardware
 */
class ActivoHardware extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
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
        return 'activo_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Asset');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Assets');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'categoria_id'], 'required'],
            [['activo_inventariable_id', 'categoria_id'], 'integer'],
            [['activo_inventariable_id'], 'unique'],
            [['precio_compra'], 'number','numberPattern' => '/^[0-9]*[.,]?[0-9]*$/']
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
            'espacio_id' => Yii::t('app', 'Space'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInventariable()
    {
        return $this->hasOne(ActivoInventariable::className(), ['id' => 'activo_inventariable_id']);
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
    public function getConfiguracionesActivoHardware()
    {
        return $this->hasMany(ConfiguracionActivoHardware::className(), ['activo_hardware_id' => 'activo_inventariable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivosSoftware()
    {
        return $this->hasMany(ActivoSoftware::className(), ['activo_inventariable_id' => 'activo_software_id'])->viaTable('configuracion_activo_hardware', ['activo_hardware_id' => 'activo_inventariable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentesHardware()
    {
        return $this->hasMany(ComponenteHardware::className(), ['activo_hardware_id' => 'activo_inventariable_id']);
    }
    
    public function getTipo()
    {
        return "Hardware";
    }
}
