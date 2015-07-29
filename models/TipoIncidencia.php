<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_incidencia".
 *
 * @property integer $id
 * @property string $nombre
 *
 * @property Incidencia[] $incidencias
 */
class TipoIncidencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_incidencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::className(), ['tipo_id' => 'id']);
    }
}
