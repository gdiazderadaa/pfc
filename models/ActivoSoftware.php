<?php

namespace app\models;

use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activo_software".
 *
 * @property string $activo_inventariable_id
 * @property string $subcategoria_activo_software_id
 *
 * @property SubcategoriaActivoSoftware $subcategoriaActivoSoftware
 * @property ActivoInventariable $activoInventariable
 * @property ConfiguracionActivoHardware[] $configuracionActivoHardwares
 * @property ActivoHardware[] $activoHardwares
 */
class ActivoSoftware extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
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
        return 'activo_software';
    }
    
    
    public static function singularObjectName(){
        return Yii::t('app', 'Software Asset');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Software Assets');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'subcategoria_activo_software_id'], 'required'],
            [['activo_inventariable_id', 'subcategoria_activo_software_id'], 'integer'],
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
            'subcategoria_activo_software_id' => Yii::t('app', 'Software Asset Subcategory'),
            'espacio_id' => Yii::t('app', 'Space'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoriaActivoSoftware()
    {
        return $this->hasOne(SubcategoriaActivoSoftware::className(), ['id' => 'subcategoria_activo_software_id']);
    }

    public function getSubcategorias() 
    { 
        $models = SubcategoriaActivoSoftware::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre');  
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
    public function getConfiguracionActivosHardware()
    {
        return $this->hasMany(ConfiguracionActivoHardware::className(), ['activo_software_id' => 'activo_inventariable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivosHardware()
    {
        return $this->hasMany(ActivoHardware::className(), ['activo_inventariable_id' => 'activo_hardware_id'])->viaTable('configuracion_activo_hardware', ['activo_software_id' => 'activo_inventariable_id']);
    }
    
    public function getTipo()
    {
        return "Software";
    }

}
