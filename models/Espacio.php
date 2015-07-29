<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "espacio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $numeracion
 * @property integer $edificio_id
 *
 * @property Edificio $edificio
 * @property Objeto[] $objetos
 */
class Espacio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'espacio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nombre', 'numeracion', 'edificio_id'], 'required'],
            [['id', 'edificio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['numeracion'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'numeracion' => 'Numeracion',
            'edificio_id' => 'Edificio ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificio::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjetos()
    {
        return $this->hasMany(Objeto::className(), ['espacio_id' => 'id']);
    }
}
