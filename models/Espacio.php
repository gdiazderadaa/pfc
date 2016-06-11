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
 * @property string $planta_edificio_id
 *
 * @property PlantaEdificio $plantaEdificio
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
            [['nombre', 'numeracion', 'planta_edificio_id'], 'required'],
            [['planta_edificio_id'], 'integer'],
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
            'planta_edificio_id' => Yii::t('app', 'Floor'),
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
    public function getActivosInfraestructura()
    {
    	return $this->getActivosInventariables()
    			->innerJoin(ActivoInfraestructura::tableName(),
    					'activo_inventariable.id = activo_infraestructura.activo_inventariable_id');
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivosHardware()
    {
    	return $this->getActivosInventariables()
    			->innerJoin(ActivoHardware::tableName(),
    					'activo_inventariable.id = activo_hardware.activo_inventariable_id');
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlantaEdificio()
    {
        return $this->hasOne(PlantaEdificio::className(), ['id' => 'planta_edificio_id']);
    }
      

    public function getPlantaEdificioList()
	{	 
        $models = PlantaEdificio::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
    	$model = $this->plantaEdificio;
    	return $model->hasOne(Edificio::className(), ['id' => 'edificio_id']);
    }
    
    public static function getEspaciosByPlantaEdificioId($plantaEdificioId) 
	{	 
        $models = Espacio::find()->where(['planta_edificio_id' => $plantaEdificioId])->all();
        return ArrayHelper::toArray($models, [
            Espacio::classname() => [
                'id',
                'name' => 'nombre',
            ],
        ]);
    }
}
