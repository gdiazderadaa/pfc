<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SubcategoriaActivoHardware".
 *
 * @property string $SubcategoriaActivoHardwareID
 * @property string $Nombre
 */
class SubcategoriaActivoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SubcategoriaActivoHardware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Nombre'], 'required'],
            [['Nombre'], 'string', 'max' => 128],
            [['Nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SubcategoriaActivoHardwareID' => 'Subcategoria Activo Hardware ID',
            'Nombre' => 'Nombre',
        ];
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoHardwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubcategoriaActivoHardwareQuery(get_called_class());
    }
}
