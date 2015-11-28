<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ActivoHardware".
 *
 * @property string $ActiovInventariableID
 * @property string $SubcategoriaID
 *
 * @property SubcategoriaActivoHardware $subcategoria
 * @property ConfiguracionActivoHardware $configuracionActivoHardware
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
        return 'ActivoHardware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ActiovInventariableID', 'SubcategoriaID'], 'required'],
            [['ActiovInventariableID', 'SubcategoriaID'], 'integer'],
            [['ActiovInventariableID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ActiovInventariableID' => 'Actiov Inventariable ID',
            'SubcategoriaID' => 'Subcategoria ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(SubcategoriaActivoHardware::className(), ['SubcategoriaActivoHardwareID' => 'SubcategoriaID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionActivoHardware()
    {
        return $this->hasOne(ConfiguracionActivoHardware::className(), ['ActivoHardwareID' => 'ActiovInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoSoftwares()
    {
        return $this->hasMany(ActivoSoftware::className(), ['ActivoInventariableID' => 'ActivoSoftwareID'])->viaTable('ConfiguracionActivoHardware', ['ActivoHardwareID' => 'ActiovInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementoHardwares()
    {
        return $this->hasMany(ElementoHardware::className(), ['ActivoHardwareID' => 'ActiovInventariableID']);
    }

    /**
     * @inheritdoc
     * @return ActivoHardwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivoHardwareQuery(get_called_class());
    }
}
