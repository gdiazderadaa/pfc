<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "valor_caracteristica_elemento_hardware".
 *
 * @property string $id
 * @property string $caracteristica_id
 * @property string $elemento_hardware_id
 * @property string $valor
 *
 * @property ElementoHardware $elementoHardware
 * @property Caracteristica $caracteristica
 */
class ValorCaracteristicaElementoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valor_caracteristica_elemento_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Element Feature-Value');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Element Features-Values');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caracteristica_id', 'elemento_hardware_id', 'valor'], 'required'],
            [['caracteristica_id', 'elemento_hardware_id'], 'integer'],
            [['valor'], 'string', 'max' => 128],
            [['elemento_hardware_id','caracteristica_id'], 'unique', 'targetAttribute' => ['elemento_hardware_id', 'caracteristica_id'], 'message'=>Yii::t('app','The selected {modelClass} is already being used by this {modelClass2}',[
                                                                                                                                    'modelClass' => $this->attributeLabels()['caracteristica_id'],
                                                                                                                                    'modelClass2' => $this->attributeLabels()['elemento_hardware_id']])]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'caracteristica_id' => Yii::t('app', 'Feature'),
            'elemento_hardware_id' => Yii::t('app', 'Hardware Element'),
            'valor' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementoHardware()
    {
        return $this->hasOne(ElementoHardware::className(), ['id' => 'elemento_hardware_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristica()
    {
        return $this->hasOne(Caracteristica::className(), ['id' => 'caracteristica_id']);
    }
    
    public function getCaracteristicas()  
    {     
        $models = Caracteristica::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre'); 
    }
    
    public function getCaracteristicasByTipoActivo($tipo)  
    {     
        return Caracteristica::find()->andFilterWhere(['like','tipo_activo',$tipo])->all(); 
        //return ArrayHelper::map($models,'id', 'nombre'); 
    }
}
