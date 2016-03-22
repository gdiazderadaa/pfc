<?php

namespace app\models;

use Yii;
use Yii\helpers\ArrayHelper;

/**
 * This is the model class for table "elemento_hardware".
 *
 * @property string $id
 * @property string $numero_serie
 * @property string $marca
 * @property string $modelo
 * @property string $fecha_compra
 * @property string $precio_compra
 * @property string $activo_hardware_id
 * @property string $subcategoria_elemento_hardware_id
 *
 * @property ActivoHardware $activoHardware
 * @property SubcategoriaActivoHardware $subcategoriaElementoHardware
 * @property ParteElementoHardware[] $parteElementoHardwares 
 * @property ValorCaracteristicaElementoHardware[] $valoresCaracteristicasElementoHardware
 * @property Caracteristica[] $caracteristicas
 */
class ElementoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elemento_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Element');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Elements');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numero_serie', 'marca', 'modelo', 'fecha_compra', 'precio_compra', 'subcategoria_elemento_hardware_id'], 'required'],
            [['fecha_compra'], 'safe'],
            //[['fecha_compra'], 'date','max'=> date("d/m/Y")],
            [['precio_compra'], 'number'],
            [['activo_hardware_id', 'subcategoria_elemento_hardware_id'], 'integer'],
            [['numero_serie', 'marca'], 'string', 'max' => 128],
            [['modelo'], 'string', 'max' => 256],
            [['numero_serie'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero_serie' => Yii::t('app', 'Serial Number'),
            'marca' => Yii::t('app', 'Manufacturer'),
            'modelo' => Yii::t('app', 'Model'),
            'fecha_compra' => Yii::t('app', 'Purchase Date'),
            'precio_compra' => Yii::t('app', 'Purchase Price'),
            'activo_hardware_id' => Yii::t('app', 'Hardware Asset'),
            'subcategoria_elemento_hardware_id' => Yii::t('app', 'Hardware Element Subcategory'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
        return $this->hasOne(ActivoHardware::className(), ['activo_inventariable_id' => 'activo_hardware_id']);
    }
    
    public function getActivoHardwareList()
    {
        $models = ActivoHardware::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }


    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSubcategoriaElementoHardware()
    {
        return $this->hasOne(SubcategoriaActivoHardware::className(), ['id' => 'subcategoria_elemento_hardware_id']);
    }
         
         
    public function getSubcategoriaElementoHardwareList()
    {
        $models = SubcategoriaActivoHardware::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
           
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasElementoHardware()
    {
        return $this->hasMany(ValorCaracteristicaElementoHardware::className(), ['elemento_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['id' => 'caracteristica_id'])->viaTable('valor_caracteristica_elemento_hardware', ['elemento_hardware_id' => 'id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPartesElementoHardware()
    {
        return $this->hasMany(ParteElementoHardware::className(), ['elemento_hardware_id' => 'id']);
    }
    
        public function getTipo()
    {
        return "Hardware";
    }
}