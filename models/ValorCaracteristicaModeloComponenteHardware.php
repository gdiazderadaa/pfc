<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "valor_caracteristica_modelo_componente_hardware".
 *
 * @property string $id
 * @property string $caracteristica_id
 * @property string $modelo_componente_hardware_id
 * @property string $valor
 *
 * @property ModeloComponenteHardware $modeloComponenteHardware
 * @property Caracteristica $caracteristica
 */
class ValorCaracteristicaModeloComponenteHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valor_caracteristica_modelo_componente_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Component Model Feature');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Component Model Features');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['caracteristica_id', 'modelo_componente_hardware_id', 'valor'], 'required'],
            [['caracteristica_id', 'modelo_componente_hardware_id'], 'integer'],
            [['valor'], 'string', 'max' => 128],
            [['caracteristica_id', 'modelo_componente_hardware_id'], 'unique', 'targetAttribute' => ['caracteristica_id', 'modelo_componente_hardware_id'], 'message' => 'The combination of Caracteristica ID and Modelo Componente Hardware ID has already been taken.'],
            [['modelo_componente_hardware_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModeloComponenteHardware::className(), 'targetAttribute' => ['modelo_componente_hardware_id' => 'id']],
            [['caracteristica_id'], 'exist', 'skipOnError' => true, 'targetClass' => Caracteristica::className(), 'targetAttribute' => ['caracteristica_id' => 'id']],
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
            'modelo_componente_hardware_id' => Yii::t('app', 'Hardware Component Model'),
            'valor' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeloComponenteHardware()
    {
        return $this->hasOne(ModeloComponenteHardware::className(), ['id' => 'modelo_componente_hardware_id']);
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
    }
}
