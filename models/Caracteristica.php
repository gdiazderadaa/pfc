<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Caracteristica".
 *
 * @property string $CaracteristicaID
 * @property string $Nombre
 * @property string $Unidades
 */
class Caracteristica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Caracteristica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Nombre'], 'string', 'max' => 64],
            [['Unidades'], 'string', 'max' => 16],
            [['Nombre'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CaracteristicaID' => 'Caracteristica ID',
            'Nombre' => 'Nombre',
            'Unidades' => 'Unidades',
        ];
    }

    /**
     * @inheritdoc
     * @return CaracteristicaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CaracteristicaQuery(get_called_class());
    }
}
