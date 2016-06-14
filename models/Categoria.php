<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categoria".
 *
 * @property string $id
 * @property string $nombre
 * @property string $tipo
 *
 * @property ModeloComponenteHardware[] $modeloComponenteHardwares
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria';
    }
    
    /**
     * @return string
     */
    public static function singularObjectName(){
        return Yii::t('app', 'Category');
    }
    
     /**
     * @return string
     */
    public static function pluralObjectName(){
        return Yii::t('app', 'Categories');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'tipo'], 'required'],
            [['tipo'], 'string'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Name'),
            'tipo' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModeloComponenteHardwares()
    {
        return $this->hasMany(ModeloComponenteHardware::className(), ['categoria_id' => 'id']);
    }
    
    /** 
    * @return array 
    */      
    public static function getCategorias()
	{	 
        $models = Categoria::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
}
