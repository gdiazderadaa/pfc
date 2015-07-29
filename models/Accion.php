<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accion".
 *
 * @property integer $id
 * @property string $fecha
 * @property string $descripcion
 * @property string $incidencia_id
 *
 * @property Incidencia $incidencia
 */
class Accion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'descripcion', 'incidencia_id'], 'required'],
            [['fecha'], 'safe'],
            [['descripcion'], 'string'],
            [['incidencia_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'incidencia_id' => 'Incidencia ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencia()
    {
        return $this->hasOne(Incidencia::className(), ['id' => 'incidencia_id']);
    }
}
