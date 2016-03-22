<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "espacio".
 *
 * @property string $id
 * @property string $nombre
 * @property string $numeracion
 * @property string $edificio_id
 *
 * @property Edificio $edificio
 * @property ActivoInventariable[] $activoInventariables 
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
    
    public static function singularObjectName(){
        return Yii::t('app', 'Space');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Spaces');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'numeracion', 'edificio_id'], 'required'],
            [['edificio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 128],
            [['numeracion'], 'string', 'max' => 24]
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
            'numeracion' => Yii::t('app', 'Space Number'),
            'edificio_id' => Yii::t('app', 'Building')
        ];
    }

    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getActivosInventariables() 
    { 
        return $this->hasMany(ActivoInventariable::className(), ['espacio_id' => 'id']); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificio::className(), ['id' => 'edificio_id']);
    }
    

    public function getEdificioList() 
	{	 
        $models = Edificio::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
}
