<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "informe".
 *
 * @property integer $id
 * @property string $fecha
 * @property integer $creador_id
 *
 * @property Usuario $creador
 */
class Informe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'informe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha'], 'safe'],
            [['creador_id'], 'required'],
            [['creador_id'], 'integer']
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
            'creador_id' => 'Creador ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'creador_id']);
    }
}
