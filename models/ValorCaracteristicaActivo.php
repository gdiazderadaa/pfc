<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            'CaracteristicaID' => 'Caracteristica',
            'ActivoInventariableID' => 'Activo',
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
    
    public function getActivosInventariables() 
	{	 
        $models = ActivoInventariable::find()->asArray()->all();
        return ArrayHelper::map($models,'ActivoInventariableID', 'Nombre');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristica()
    {
        return $this->hasOne(Caracteristica::className(), ['CaracteristicaID' => 'CaracteristicaID']);
    }
    
    public function getCaracteristicas() 
	{	 
        $models = Caracteristica::find()->asArray()->all();
        return ArrayHelper::map($models,'CaracteristicaID', 'Nombre');
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
