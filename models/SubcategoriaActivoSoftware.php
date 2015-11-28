<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SubcategoriaActivoSoftware".
 *
 * @property string $SubcategoriaActivoSoftwareID
 * @property string $Nombre
 */
class SubcategoriaActivoSoftware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SubcategoriaActivoSoftware';
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
            'SubcategoriaActivoSoftwareID' => 'Subcategoria Activo Software ID',
            'Nombre' => 'Nombre',
        ];
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoSoftwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubcategoriaActivoSoftwareQuery(get_called_class());
    }
}
