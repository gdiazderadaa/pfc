<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "edificio".
 *
 * @property string $id
 * @property string $nombre
 * @property string $localidad
 *
 * @property PlantaEdificio[] $plantasEdificio
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
    
    public static function singularObjectName(){
        return Yii::t('app', 'Building');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Buildings');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'localidad'], 'required'],
            [['nombre', 'localidad'], 'string'],
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
            'localidad' => Yii::t('app', 'Town/City'),
            'planta_edificio_id' => Yii::t('app','Floor'),
        ];
    }
    
    	 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getPlantasEdificio() 
    { 
        return $this->hasMany(PlantaEdificio::className(), ['edificio_id' => 'id']); 
    } 
}
