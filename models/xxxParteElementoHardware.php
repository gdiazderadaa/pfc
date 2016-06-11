<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Query;

/**
 * This is the model class for table "parte_elemento_hardware".
 *
 * @property string $id
 * @property string $elemento_hardware_id
 * @property string $parte_elemento_hardware_id
 *
 * @property ElementoHardware $elementoHardware
 * @property ElementoHardware $parteElementoHardware
 */
class ParteElementoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parte_elemento_hardware';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Hardware Element Part');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Hardware Element Parts');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['elemento_hardware_id', 'parte_elemento_hardware_id'], 'required'],
            [['elemento_hardware_id', 'parte_elemento_hardware_id'], 'integer'],
            [['elemento_hardware_id', 'parte_elemento_hardware_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'elemento_hardware_id' => Yii::t('app', 'Hardware Element'),
            'parte_elemento_hardware_id' => Yii::t('app', 'Hardware Element Part'),
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
    public function getElementosHardware()
    {
        $models = ElementoHardware::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'modelo'); 
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFreePartesElementoHardware($id)
    {
        // TODO: Avoid ciclic relations A-> B-> A
        $models = ElementoHardware::find()->where(['not in', 'id', (new Query())->select('parte_elemento_hardware_id')->from('parte_elemento_hardware')])
                                            ->andWhere(['not in', 'id',$this->getParentChain($id)])->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'modelo'); 
    }
    
    
    public function getParentChain($id)
    {
        $model = $this->elementoHardware;
        $part = ParteElementoHardware::find()->where(['parte_elemento_hardware_id' => $id])->one();
        $parents = array();
        while ($part){
            $parents[] = $part->elemento_hardware_id;
            $part = ParteElementoHardware::find()->where(['parte_elemento_hardware_id' => $part->elemento_hardware_id])->one();
        }
        return $parents;
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParteElementoHardware()
    {
        return $this->hasOne(ElementoHardware::className(), ['id' => 'parte_elemento_hardware_id']);
    }
    
    
}
