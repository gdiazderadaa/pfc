<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Categoria;

/**
 * This is the model class for table "componente_hardware".
 *
 * @property string $id
 * @property string $numero_serie
 * @property string $estado
 * @property string $modelo_componente_hardware_id
 * @property string $fecha_compra
  * @property string $meses_garantia 
 * @property string $precio_compra
 * @property string $activo_hardware_id
 *
 * @property ActivoHardware $activoHardware
 * @property ModeloComponenteHardware $modeloComponenteHardware
 * @property ParteComponenteHardware[] $componentesHardware
 * @property ParteComponenteHardware[] $partesComponenteHardware
 * @property ValorCaracteristicaComponenteHardware[] $valorCaracteristicaComponenteHardwares
 * @property Caracteristica[] $caracteristicas
 */
class ComponenteHardware extends \yii\db\ActiveRecord
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
    const INVENTORY_OFF = 'Inventario desactivado';
    
    public $cantidad;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'componente_hardware';
    }
    
    /**
     * @return string
     */
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Component');
    }
    
     /**
     * @return string
     */
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Components');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $inventario = function($model) { return $model->modeloComponenteHardware != null ? $model->modeloComponenteHardware->inventario : false ; };
        return [
            [['estado', 'modelo_componente_hardware_id', 'fecha_compra', 'precio_compra'], 'required'],
            [['modelo_componente_hardware_id', 'activo_hardware_id','meses_garantia'], 'integer'],
            [['fecha_compra'], 'safe'],
            [['precio_compra'], 'number','numberPattern' => '/^[0-9]*[.,]?[0-9]*$/'],
            [['numero_serie', 'estado'], 'string', 'max' => 128],
            [['numero_serie'], 'unique'],
            [['activo_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivoHardware::className(), 'targetAttribute' => ['activo_hardware_id' => 'activo_inventariable_id']],
            [['modelo_componente_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModeloComponenteHardware::className(), 'targetAttribute' => ['modelo_componente_hardware_id' => 'id']],
            [['numero_serie'], 'required','when' => $inventario, 'whenClient' => "function (attribute, value) {
                return $('#componentehardware-estado').val() != '".self::INVENTORY_OFF."';
            }"],
        	[['cantidad'], 'required','when' => $inventario],
        	[['cantidad'],'integer'],
        	[['cantidad'],'compare', 'compareValue' => 0, 'operator' => '>'],
        ];
    }
    
    
     /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['Create'] = ['estado','password', 'modelo_componente_hardware_id', 'fecha_compra','meses_garantia','precio_compra','activo_hardware_id','cantidad'];
        $scenarios['Update'] = ['estado','password', 'modelo_componente_hardware_id', 'fecha_compra','meses_garantia','precio_compra','activo_hardware_id','numero_serie'];
        $scenarios['Clone'] = ['estado','password', 'modelo_componente_hardware_id', 'fecha_compra','meses_garantia','precio_compra','activo_hardware_id','numero_serie'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'estado' => Yii::t('app', 'Turn on the inventory on the model to keep track of the status'),
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
            'estado' => Yii::t('app', 'Status'),
            'modelo_componente_hardware_id' => Yii::t('app', 'Hardware Component Model'),
            'fecha_compra' => Yii::t('app', 'Purchase Date'),
            'meses_garantia' => Yii::t('app','Warranty'),
            'fechaFinGarantia' => Yii::t('app','Warranty End Date'),
            'precio_compra' => Yii::t('app', 'Purchase Price'),
            'activo_hardware_id' => Yii::t('app', 'Hardware Asset'),
            'marcaModeloComponenteHardware' => Yii::t('app','Manufacturer'),
            'modeloModeloComponenteHardware' => Yii::t('app','Model')
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
        return $this->hasOne(ActivoHardware::className(), ['activo_inventariable_id' => 'activo_hardware_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeloComponenteHardware()
    {
        return $this->hasOne(ModeloComponenteHardware::className(), ['id' => 'modelo_componente_hardware_id']);
    }
    
    /**
     * @return string
     */
    public function getMarcaModeloComponenteHardware() 
    {
        return $this->modeloComponenteHardware->marca;
    }
    
    /**
     * @return string
     */
    public function getModeloModeloComponenteHardware() 
    {
        return $this->modeloComponenteHardware->modelo;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelosComponenteHardware()
    {
        $models = ModeloComponenteHardware::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', function($model, $defaultValue) {
                                                    return $model['marca'].' '.$model['modelo'];
                                                },
                                                function($model, $defaultValue) {
                                                    $categoria = Categoria::findOne($model['categoria_id']);
                                                    return $categoria->nombre;
                                                }); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentesHardware()
    {
        return $this->hasMany(ParteComponenteHardware::className(), ['parte_componente_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartesComponenteHardware()
    {
        return $this->hasMany(ParteComponenteHardware::className(), ['componente_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorCaracteristicaComponenteHardwares()
    {
        return $this->hasMany(ValorCaracteristicaComponenteHardware::className(), ['componente_hardware_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['id' => 'caracteristica_id'])->viaTable('valor_caracteristica_componente_hardware', ['componente_hardware_id' => 'id']);
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
    
    public static function getEstadosByModelo($modeloComponenteHardwareId) 
	{	
        $model = ModeloComponenteHardware::findOne($modeloComponenteHardwareId);

        if ($model->inventario == 1){
            $estados = [];
            $count = -1;
            foreach (self::getEstados() as $key => $value) {
               $estados[++$count] = ['id' => $key, 'name' => $value];
            }
            return $estados;
        }
        else{
            return ArrayHelper::toArray( [[ 'id' => self::INVENTORY_OFF,
                        'name'  => Yii::t('app','Inventario desactivado')]]);
        }
    }
    
    /**
    * @return string
    */    
    public function getFechaFinGarantia()
    {
        if ($this->meses_garantia != null){
            $date=new \DateTime($this->fecha_compra);
            $date->add(new \DateInterval('P'.$this->meses_garantia.'M'));
            return $date;
        } else {
            return null;
        } 
    }
    
    /**
     * @return boolean
     */
    public function getEnGarantia()
    {
        $date = new \DateTime();
        return $this->getFechaFinGarantia() >= $date;
    }
    
    /**
     * @return string
     */
    public function getTextoGarantia()
    {
    	switch ($this->meses_garantia) {
    		case null:
    			return Yii::t('app','No warranty');
    		break;
    		case !null:
    			return $this->enGarantia ? Yii::t('app','Under warranty') : Yii::t('app','Out of warranty');
    		default:
    			;
    		break;
    	}
    	$date = new \DateTime();
    	return $this->getFechaFinGarantia() >= $date;
    }
    
    /**
     * @return boolean
     */
    public function getGarantiaExpirada()
    {
        return !$this->getEnGarantia()  && $this->meses_garantia != null;
    }
    
    /**
    * @return string
    */    
    public function getNombre()
    {
        return $this->numero_serie != null ? 
                sprintf("%s (%s)", $this->modeloComponenteHardware->nombre, $this->numero_serie) 
                : $this->modeloComponenteHardware->nombre;
    }
    
    /**
    * @return array
    */ 
    public static function getComponentesByModelo($modeloId) 
	{	

        $models = ComponenteHardware::find()
         			->where(['modelo_componente_hardware_id'=>$modeloId])->all();
//         			->joinWith('modeloComponenteHardware')
//          			->where(['modelo_componente_hardware.inventario' => 0])
//          			->orWhere(['not in','componente_hardware.id',ParteComponenteHardware::find()->select('parte_componente_hardware_id')->distinct()])->all();
        	
         if (sizeof($models) > 0) {
        	return ArrayHelper::toArray($models, [
        			ComponenteHardware::classname() => [
        				'id',
        				'name' => function($model){
	        				return $model->numero_serie != null ?
	        				$model->numero_serie :
	        				Yii::t('app', 'Unique part (inventory off)');
        				}
        			],
        	]);
        }
        else{
        	return [];
        }			
        
    }
}
