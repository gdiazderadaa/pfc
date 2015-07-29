<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "objeto".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $espacio_id
 * @property integer $tipo_id
 *
 * @property Espacio $espacio
 * @property TipoObjeto $tipo
 */
class Objeto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objeto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'espacio_id', 'tipo_id'], 'required'],
            [['espacio_id', 'tipo_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128]
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
            'espacio_id' => 'Espacio ID',
            'tipo_id' => 'Tipo ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacio()
    {
        return $this->hasOne(Espacio::className(), ['id' => 'espacio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoObjeto::className(), ['id' => 'tipo_id']);
    }
}
