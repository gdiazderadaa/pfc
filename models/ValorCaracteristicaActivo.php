<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ValorCaracteristicaActivo".
 *
 * @property string $CaracteristicaID
 * @property string $ActivoInventariableID
 * @property string $Valor
 *
 * @property ActivoInventariable $activoInventariable
 * @property Caracteristica $caracteristica
 */
class ValorCaracteristicaActivo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ValorCaracteristicaActivo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CaracteristicaID', 'ActivoInventariableID', 'Valor'], 'required'],
            [['CaracteristicaID', 'ActivoInventariableID'], 'integer'],
            [['Valor'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CaracteristicaID' => 'Caracteristica ID',
            'ActivoInventariableID' => 'Activo Inventariable ID',
            'Valor' => 'Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInventariable()
    {
        return $this->hasOne(ActivoInventariable::className(), ['ActivoInventariableID' => 'ActivoInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristica()
    {
        return $this->hasOne(Caracteristica::className(), ['CaracteristicaID' => 'CaracteristicaID']);
    }

    /**
     * @inheritdoc
     * @return ValorCaracteristicaActivoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ValorCaracteristicaActivoQuery(get_called_class());
    }
}
