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
 * @property string $fecha_fin_garantia 
 * @property string $estado
 *
 * @property ActivoHardware $activoHardware
 * @property SubcategoriaActivoHardware $subcategoriaElementoHardware
 * @property ParteElementoHardware[] $parteElementoHardwares 
 * @property ValorCaracteristicaElementoHardware[] $valoresCaracteristicasElementoHardware
 * @property Caracteristica[] $caracteristicas
 */
class ElementoHardware extends \yii\db\ActiveRecord
{
    const ORDERED = 'Pedido';
    const RECEIVED = 'Recibido';
    const AWAITING_TAG = 'Esperando Etiquetado';
    const AVAILABLE = 'Disponible';
    const IN_USE = 'En Uso';
    const BROKEN = 'Averiado';
    const IN_REPAIR = 'En Reparación';
    const IN_EXTERNAL_REPAIR = 'En Reparación (por terceros)';
    const RMA = 'RMA';
    const LOST = 'Perdido';
    const LEND = 'Prestado';
    const DISPOSED = 'Retirado';
    
    
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
            [['numero_serie', 'marca', 'modelo', 'fecha_compra', 'precio_compra', 'subcategoria_elemento_hardware_id','estado'], 'required'],
            [['fecha_compra'], 'safe'],
            //[['fecha_compra'], 'date','max'=> date("d/m/Y")],
            [['precio_compra'], 'number'],
            [['activo_hardware_id', 'subcategoria_elemento_hardware_id'], 'integer'],
            [['numero_serie', 'marca','estado'], 'string', 'max' => 128],
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
            'fecha_fin_garantia' => Yii::t('app', 'Warranty Expiration Date'),
            'estado' => Yii::t('app', 'Status'),
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
        $models = ActivoHardware::find()->joinWith('activoInventariable')->asArray()->all();
        return ArrayHelper::map($models,'activo_inventariable_id', 'activoInventariable.nombre');
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
    
    
    /**
    * @return string
    */   
    public function getTipo()
    {
        return "Hardware";
    }
    
    
    /**
    * @return array
    */    
    public function getEstados()
    {
        return [
            self::ORDERED            => Yii::t('app','Ordered'),
            self::RECEIVED           => Yii::t('app','Received'),
            self::AWAITING_TAG       => Yii::t('app','Awaiting Tag'),
            self::AVAILABLE          => Yii::t('app','Operational'),
            self::IN_USE             => Yii::t('app','In Use'),
            self::BROKEN             => Yii::t('app','Broken'),
            self::IN_REPAIR          => Yii::t('app','In Repair'),
            self::IN_EXTERNAL_REPAIR => Yii::t('app','In Repair (By a third company)'),
            self::RMA                => Yii::t('app','RMA'),
            self::LOST               => Yii::t('app','Lost'),
            self::LEND               => Yii::t('app','Lend'),
            self::DISPOSED           => Yii::t('app','Disposed'),           
        ];
    }
}
