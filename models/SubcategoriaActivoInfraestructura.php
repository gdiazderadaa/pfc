<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SubcategoriaActivoInfraestructura".
 *
 * @property string $SubcategoriaActivoInfraestructuraID
 * @property string $Nombre
 */
class SubcategoriaActivoInfraestructura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SubcategoriaActivoInfraestructura';
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
            'SubcategoriaActivoInfraestructuraID' => 'Subcategoria Activo Infraestructura ID',
            'Nombre' => 'Nombre',
        ];
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoInfraestructuraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubcategoriaActivoInfraestructuraQuery(get_called_class());
    }
}
