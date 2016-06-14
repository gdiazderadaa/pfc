<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activo_hardware_componente_hardware".
 *
 * @property string $id
 * @property string $activo_hardware_id
 * @property string $componente_hardware_id
 *
 *
 * @property ActivoHardware $activoHardware
 * @property ComponenteHardware $componenteHardware
 */
class ActivoHardwareComponenteHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activo_hardware_componente_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Asset Component');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Asset Components');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_hardware_id', 'componente_hardware_id'], 'required'],
            [['activo_hardware_id', 'componente_hardware_id'], 'integer'],
            [['activo_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivoHardware::className(), 'targetAttribute' => ['activo_hardware_id' => 'activo_inventariable_id']],
            [['componente_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponenteHardware::className(), 'targetAttribute' => ['componente_hardware_id' => 'id']],
            [['componente_hardware_id'], 'unique', 'targetAttribute' => ['activo_hardware_id', 'componente_hardware_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activo_hardware_id' => Yii::t('app', 'Hardware Asset'),
        	'componente_hardware_id' => Yii::t('app', 'Hardware Component'),
        ];
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
    	return $this->hasOne(ComponenteHardware::className(), ['activo_inventariable_id' => 'activo_hardware_id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponenteHardware()
    {
        return $this->hasOne(ComponenteHardware::className(), ['id' => 'componente_hardware_id']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentesHardware()
    {
        $models = ComponenteHardware::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'modelo'); 
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreeComponentesHardware($id)
    {
    	
//      	var_dump( Yii::$app->db->createCommand('SELECT componente_hardware.* 
// 												FROM pfc_german_db.componente_hardware 
// 												INNER JOIN  modelo_componente_hardware ON modelo_componente_hardware.id = componente_hardware.modelo_componente_hardware_id
// 												WHERE (modelo_componente_hardware.inventario = 0 
// 													AND componente_hardware.id NOT IN (SELECT componente_hardware_id FROM activo_hardware_componente_hardware WHERE activo_hardware_id = 30 ))
// 												OR (modelo_componente_hardware.inventario = 1 
// 													AND componente_hardware.id NOT IN (SELECT componente_hardware_id FROM activo_hardware_componente_hardware)
//             										AND componente_hardware.id NOT IN (SELECT parte_componente_hardware_id FROM parte_componente_hardware))')->queryAll());return exit();

    	
    	
    	$models = ComponenteHardware::find()->joinWith('modeloComponenteHardware')
    										->where(['and',['inventario' => 0], 
    														['not in', 'componente_hardware.id', ActivoHardwareComponenteHardware::find()->where(['activo_hardware_id' => $id])->select('componente_hardware_id')->asArray()->all()]
    												
    										])
    										->orWhere(['and',['modelo_componente_hardware.inventario' => 1], 
    														['not in', 'componente_hardware.id', ActivoHardwareComponenteHardware::find()->select('componente_hardware_id')->asArray()->all()],
    														['not in', 'componente_hardware.id', ParteComponenteHardware::find()->select('parte_componente_hardware_id')->asArray()->all()],
    										])
    										->asArray()->all();
    	
        
        return ArrayHelper::map($models,'id', function($model, $defaultValue) {
	        										if($model['numero_serie'] != null){
	        											return $model['modeloComponenteHardware']['marca'].' '.$model['modeloComponenteHardware']['modelo'].' ('.$model['numero_serie'].')';
	        										}
	        										else{
	        											return $model['modeloComponenteHardware']['marca'].' '.$model['modeloComponenteHardware']['modelo'];
	        										}
                                                    
                                                },
                                                function($model, $defaultValue) {
                                                    $categoria = Categoria::findOne($model['modeloComponenteHardware']['categoria_id']);
                                                    return $categoria->nombre;
                                                }); 
    }
    
    
    public function getParentChain($id)
    {
        $model = $this->componenteHardware;
        $part = ParteComponenteHardware::find()->where(['parte_componente_hardware_id' => $id])->one();
        $parents = array();
        while ($part){
            $parents[] = $part->componente_hardware_id;
            $part = ParteComponenteHardware::find()->where(['parte_componente_hardware_id' => $part->componente_hardware_id])->one();
        }
        return $parents;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAvailableComponentesHardware()
    {
        $models = ComponenteHardware::find()->joinWith('modeloComponenteHardware')->asArray()->all(); 
        return ArrayHelper::map($models,'id', function($model, $defaultValue) {
                                                    return $model['modeloComponenteHardware']['marca'].' '.$model['modeloComponenteHardware']['modelo'];
                                                },
                                                function($model, $defaultValue) {
                                                    $categoria = Categoria::findOne($model['modeloComponenteHardware']['categoria_id']);
                                                    return $categoria->nombre;
                                                }); 
    }
}
