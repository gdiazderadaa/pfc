<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "parte_componente_hardware".
 *
 * @property string $id
 * @property string $componente_hardware_id
 * @property string $parte_componente_hardware_id
 *
 * @property ComponenteHardware $componenteHardware
 * @property ComponenteHardware $parteComponenteHardware
 */
class ParteComponenteHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parte_componente_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Component Part');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Component Parts');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['componente_hardware_id', 'parte_componente_hardware_id'], 'required'],
            [['componente_hardware_id', 'parte_componente_hardware_id'], 'integer'],
            [['componente_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponenteHardware::className(), 'targetAttribute' => ['componente_hardware_id' => 'id']],
            [['parte_componente_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponenteHardware::className(), 'targetAttribute' => ['parte_componente_hardware_id' => 'id']],
            [['parte_componente_hardware_id'], 'unique', 'targetAttribute' => ['componente_hardware_id', 'parte_componente_hardware_id']],
            [['parte_componente_hardware_id'], 'compare', 'compareAttribute' => 'componente_hardware_id', 'operator' => '!=', 'message' => Yii::t('app','A part cannot be attached to itself')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'componente_hardware_id' => Yii::t('app', 'Hardware Component'),
            'parte_componente_hardware_id' => Yii::t('app', 'Hardware Component Part'),
        ];
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
    public function getParteComponenteHardware()
    {
        return $this->hasOne(ComponenteHardware::className(), ['id' => 'parte_componente_hardware_id']);
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
    public function getFreePartesComponenteHardware($id)
    {
    	$hardwareComponent = ComponenteHardware::findOne($id);
    	if ($hardwareComponent->modeloComponenteHardware->inventario) {
    		$models = ComponenteHardware::find()->joinWith('modeloComponenteHardware')
    											->where(['modelo_componente_hardware.inventario' => 1])
    											->andWhere(['not in', 'componente_hardware.id', 
    													(new yii\db\Query())->select('parte_componente_hardware_id')
    																		->from('parte_componente_hardware')])
    											->andWhere(['not in', 'componente_hardware.id',$this->getParentChain($id)])->asArray()->all();
    	}
    	else {
    		$models = ComponenteHardware::find()->joinWith('modeloComponenteHardware')->where(['modelo_componente_hardware.inventario' => 0])
    																					->andWhere(['!=', 'componente_hardware.id',$id])->asArray()->all();
    	}
    	
        
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
