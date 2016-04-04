<?php

namespace app\models;

use Yii;
use Yii\helpers\ArrayHelper;
/**
 * This is the model class for table "activo_inventariable".
 *
 * @property string $id
 * @property string $codigo
 * @property string $nombre
 * @property string $fecha_compra
 * @property string $precio_compra
 * @property string $espacio_id
 *
 * @property ActivoHardware $activoHardware
 * @property ActivoInfraestructura $activoInfraestructura
 * @property Espacio $espacio
 * @property ActivoSoftware $activoSoftware
 * @property Incidencia[] $incidencias
 * @property ValorCaracteristicaActivoInventariable[] $valoresCaracteristicasActivoInventariable
 */
class ActivoInventariable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activo_inventariable';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Asset');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Assets');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nombre', 'fecha_compra', 'precio_compra'], 'required'],
            [['fecha_compra'], 'safe'],
            [['precio_compra'], 'number','numberPattern' => '/^[0-9]*[.,]?[0-9]*$/'],
            [['espacio_id'], 'integer'],
            [['codigo'], 'string', 'max' => 128],
            [['nombre'], 'string', 'max' => 64],
            [['codigo'], 'unique'],
            [['precio_compra'], 'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Asset Number'),
            'nombre' => Yii::t('app', 'Name'),
            'fecha_compra' => Yii::t('app', 'Purchase Date'),
            'precio_compra' => Yii::t('app', 'Purchase Price'),
            'espacio_id' => Yii::t('app', 'Space'),
        ];
    }
    
    /**
    * @inheritdoc
    */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->precio_compra = str_replace(",",".",$this->precio_compra);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
        return $this->hasOne(ActivoHardware::className(), ['activo_inventariable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInfraestructura()
    {
        return $this->hasOne(ActivoInfraestructura::className(), ['activo_inventariable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacio()
    {
        return $this->hasOne(Espacio::className(), ['id' => 'espacio_id']);
    }

    public function getEspacios() 
    { 
        $models = Espacio::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre');  
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoSoftware()
    {
        return $this->hasOne(ActivoSoftware::className(), ['activo_inventariable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::className(), ['activo_inventariable_id' => 'id']);
    }

    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['caracteristica_id' => 'id'])->viaTable('valor_caracteristica_activo_inventariable', ['activo_inventariable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasActivoInventariable()
    {
        return $this->hasMany(ValorCaracteristicaActivoInventariable::className(), ['activo_inventariable_id' => 'id']);
    }
}
