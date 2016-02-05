<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edificio".
 *
 * @property string $id
 * @property string $nombre
 * @property string $localidad
 *
 * @property Espacio[] $espacios
 */
class Edificio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edificio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'localidad'], 'required'],
            [['nombre', 'localidad'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'localidad' => Yii::t('app', 'Localidad'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacios()
    {
        return $this->hasMany(Espacio::className(), ['edificio_id' => 'id']);
    }
}
