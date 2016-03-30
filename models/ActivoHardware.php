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
 * @property string $subcategoria_activo_hardware_id
 *
 * @property ActivoInventariable $activoInventariable
 * @property SubcategoriaActivoHardware $subcategoriaActivoHardware
 * @property ConfiguracionActivoHardware[] $configuracionesActivoHardware
 * @property ActivoSoftware[] $activoSoftwares
 * @property ElementoHardware[] $elementosHardware
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
            [['activo_inventariable_id', 'subcategoria_activo_hardware_id'], 'required'],
            [['activo_inventariable_id', 'subcategoria_activo_hardware_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activo_inventariable_id' => Yii::t('app', 'Asset'),
            'subcategoria_activo_hardware_id' => Yii::t('app', 'Hardware Asset Subcategory'),
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
    public function getSubcategoriaActivoHardware()
    {
        return $this->hasOne(SubcategoriaActivoHardware::className(), ['id' => 'subcategoria_activo_hardware_id']);
    }
    
    public function getSubcategorias() 
    { 
        $models = SubcategoriaActivoHardware::find()->asArray()->all(); 
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
    public function getElementosHardware()
    {
        return $this->hasMany(ElementoHardware::className(), ['activo_hardware_id' => 'activo_inventariable_id']);
    }
    
        public function getTipo()
    {
        return "Hardware";
    }
}
