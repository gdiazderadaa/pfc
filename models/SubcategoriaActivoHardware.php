<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcategoria_activo_hardware".
 *
 * @property string $id
 * @property string $nombre
 *
 * @property ActivoHardware[] $activoHardwares
 */
class SubcategoriaActivoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subcategoria_activo_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Asset Subcategory');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Asset Subcategories');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardwares()
    {
        return $this->hasMany(ActivoHardware::className(), ['subcategoria_activo_hardware_id' => 'id']);
    }
}
