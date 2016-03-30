<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "configuracion_activo_hardware".
 *
 * @property string $id
 * @property string $activo_hardware_id
 * @property string $activo_software_id
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
        return 'configuracion_activo_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Asset Configuration');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Assets Configurations');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_hardware_id', 'activo_software_id'], 'required'],
            [['activo_hardware_id', 'activo_software_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activo_hardware_id' => Yii::t('app', 'Hardware Asset'),
            'activo_software_id' => Yii::t('app', 'Software Asset'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
        return $this->hasOne(ActivoHardware::className(), ['activo_inventariable_id' => 'activo_hardware_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoSoftware()
    {
        return $this->hasOne(ActivoSoftware::className(), ['activo_inventariable_id' => 'activo_software_id']);
    }
    
    public function getActivosSoftware()  
    {     
        // $models = ActivoSoftware::find()->asArray()->all(); 
        // return ArrayHelper::map($models,'activo_inventariable_id', 'nombre');
        return ActivoSoftware::find()->all();
    }
}
