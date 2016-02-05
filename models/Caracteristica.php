<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caracteristica".
 *
 * @property string $id
 * @property string $nombre
 * @property string $unidades
 *
 * @property ValorCaracteristicaActivoInventariable[] $valorCaracteristicaActivoInventariables
 * @property ValorCaracteristicaElementoHardware[] $valorCaracteristicaElementoHardwares
 * @property ElementoHardware[] $elementoHardwares
 */
class Caracteristica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caracteristica';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 64],
            [['unidades'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Name'),
            'unidades' => Yii::t('app', 'Units'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorCaracteristicaActivosInventariables()
    {
        return $this->hasMany(ValorCaracteristicaActivoInventariable::className(), ['caracteristica_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorCaracteristicaElementosHardware()
    {
        return $this->hasMany(ValorCaracteristicaElementoHardware::className(), ['caracteristica_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementosHardware()
    {
        return $this->hasMany(ElementoHardware::className(), ['id' => 'elemento_hardware_id'])->viaTable('valor_caracteristica_elemento_hardware', ['caracteristica_id' => 'id']);
    }
}
