<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ActivoSoftware".
 *
 * @property string $ActivoInventariableID
 * @property string $SubcategoriaID
 *
 * @property SubcategoriaActivoSoftware $subcategoria
 * @property ConfiguracionActivoHardware $configuracionActivoHardware
 * @property ActivoHardware[] $activoHardwares
 */
class ActivoSoftware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ActivoSoftware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ActivoInventariableID', 'SubcategoriaID'], 'required'],
            [['ActivoInventariableID', 'SubcategoriaID'], 'integer'],
            [['ActivoInventariableID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ActivoInventariableID' => 'Activo Inventariable ID',
            'SubcategoriaID' => 'Subcategoria ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(SubcategoriaActivoSoftware::className(), ['SubcategoriaActivoSoftwareID' => 'SubcategoriaID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionActivoHardware()
    {
        return $this->hasOne(ConfiguracionActivoHardware::className(), ['ActivoSoftwareID' => 'ActivoInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardwares()
    {
        return $this->hasMany(ActivoHardware::className(), ['ActiovInventariableID' => 'ActivoHardwareID'])->viaTable('ConfiguracionActivoHardware', ['ActivoSoftwareID' => 'ActivoInventariableID']);
    }

    /**
     * @inheritdoc
     * @return ActivoSoftwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivoSoftwareQuery(get_called_class());
    }
}
