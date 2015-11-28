<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ConfiguracionActivoHardware".
 *
 * @property string $ActivoHardwareID
 * @property string $ActivoSoftwareID
 *
 * @property ActivoHardware $activoHardware
 * @property ActivoSoftware $activoSoftware
 */
class ConfiguracionActivoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ConfiguracionActivoHardware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ActivoHardwareID', 'ActivoSoftwareID'], 'required'],
            [['ActivoHardwareID', 'ActivoSoftwareID'], 'integer'],
            [['ActivoHardwareID'], 'unique'],
            [['ActivoSoftwareID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ActivoHardwareID' => 'Activo Hardware ID',
            'ActivoSoftwareID' => 'Activo Software ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
        return $this->hasOne(ActivoHardware::className(), ['ActiovInventariableID' => 'ActivoHardwareID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoSoftware()
    {
        return $this->hasOne(ActivoSoftware::className(), ['ActivoInventariableID' => 'ActivoSoftwareID']);
    }

    /**
     * @inheritdoc
     * @return ConfiguracionActivoHardwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfiguracionActivoHardwareQuery(get_called_class());
    }
}
