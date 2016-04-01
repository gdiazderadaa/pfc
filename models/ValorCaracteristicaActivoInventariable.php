<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "valor_caracteristica_activo_inventariable".
 *
 * @property string $id
 * @property string $activo_inventariable_id
 * @property string $caracteristica_id
 * @property string $valor
 *
 * @property ActivoInventariable $activoInventariable
 * @property Caracteristica $caracteristica
 */
class ValorCaracteristicaActivoInventariable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'valor_caracteristica_activo_inventariable';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Asset Feature');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Asset Features');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'caracteristica_id', 'valor'], 'required'],
            [['activo_inventariable_id', 'caracteristica_id'], 'integer'],
            [['valor'], 'string', 'max' => 128],
            ['caracteristica_id', 'unique', 'targetAttribute' => ['activo_inventariable_id', 'caracteristica_id'], 
                                                                'message'=>Yii::t('app','The selected {modelClass} is already being used by this {modelClass2}',[
                                                                                            'modelClass' => $this->attributeLabels()['caracteristica_id'],
                                                                                            'modelClass' => $this->attributeLabels()['activo_inventariable_id']])]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activo_inventariable_id' => Yii::t('app', 'Asset'),
            'caracteristica_id' => Yii::t('app', 'Feature'),
            'valor' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInventariable()
    {
        return $this->hasOne(ActivoInventariable::className(), ['id' => 'activo_inventariable_id']);
    }
    
    public function getActivosInventariables()  
    {     
        $models = ActivoInventariable::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre'); 
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
        $models = Caracteristica::find()->andFilterWhere(['like','tipo_activo',$tipo])->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre'); 
    }
}
