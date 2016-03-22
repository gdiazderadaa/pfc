<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activo_hardware".
 *
 * @property string $activo_inventariable_id
 * @property string $subcategoria_activo_hardware_id
 *
 * @property ActivoInventariable $activoInventariable
 * @property SubcategoriaActivoHardware $subcategoriaActivoHardware
 * @property ConfiguracionActivoHardware[] $configuracionActivoHardwares
 * @property ActivoSoftware[] $activoSoftwares
 * @property ElementoHardware[] $elementoHardwares
 */
class ActivoHardware extends \yii\db\ActiveRecord
{
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionActivoHardwares()
    {
        return $this->hasMany(ConfiguracionActivoHardware::className(), ['activo_hardware_id' => 'activo_inventariable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoSoftwares()
    {
        return $this->hasMany(ActivoSoftware::className(), ['activo_inventariable_id' => 'activo_software_id'])->viaTable('configuracion_activo_hardware', ['activo_hardware_id' => 'activo_inventariable_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementoHardwares()
    {
        return $this->hasMany(ElementoHardware::className(), ['activo_hardware_id' => 'activo_inventariable_id']);
    }
}
