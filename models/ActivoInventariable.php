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
 * @property string $meses_garantia 
 * @property string $estado
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
    
    const MONTHS = 0;
    const YEARS = 1;

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
            [['codigo', 'nombre', 'fecha_compra', 'precio_compra','estado'], 'required'],
            [['fecha_compra'], 'safe'],
            [['precio_compra'], 'number','numberPattern' => '/^[0-9]*[.,]?[0-9]*$/'],
            [['espacio_id','meses_garantia'], 'integer'],
            [['codigo', 'estado'], 'string', 'max' => 128],
            [['nombre'], 'string', 'max' => 64],
            [['codigo'], 'unique'],
            [['precio_compra'], 'compare', 'compareValue' => 0, 'operator' => '>','type' => 'number'],
            [['espacio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Espacio::className(), 'targetAttribute' => ['espacio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Asset Tag'),
            'nombre' => Yii::t('app', 'Name'),
            'fecha_compra' => Yii::t('app', 'Purchase Date'),
            'precio_compra' => Yii::t('app', 'Purchase Price'),
            'espacio_id' => Yii::t('app', 'Room'),
            'meses_garantia' => Yii::t('app', 'Warranty'),
            'estado' => Yii::t('app', 'Status'),
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
    
    public function getEdificioList()
	{	 
        $models = Edificio::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
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
    
    
    public function setFechaFinGarantia($lenght, $unit)
    {
        $fecha = new \DateTime($this->fecha_compra);
        if ($unit == self::YEARS) {
            $interval = 'P'.$lenght.'Y';
        }
        else{
            $interval = 'P'.$lenght.'M';
        }

        $this->fecha_fin_garantia =  $fecha->add(new \DateInterval($interval))->format('Y-m-d');        
    }
    
    
    /**
    * @return boolean
    */
    public function enGarantia()
    {
        $fecha = new \DateTime($this->fecha_fin_garantia);
        $hoy = new \DateTime("now");
        
        return ($fecha > $hoy);
    }  
    
    
    /**
    * @return string
    */
    public function getTextoGarantia()
    {
        return $this->enGarantia() ?
                          Yii::t('app','Under Warranty')
                        : Yii::t('app','Expired Warranty');
    } 
    
    
    /**
    * @return array
    */
    public function getTiposGarantia()
    {
        return [
            self::MONTHS => Yii::t('app','Months'),
            self::YEARS  => Yii::t('app','Years')         
        ];
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
            self::DISPOSED           => Yii::t('app','Disposed')
        ];
    }
}
