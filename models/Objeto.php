<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "objeto".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $espacio_id
 * @property integer $tipo_id
 *
 * @property Espacio $espacio
 * @property TipoObjeto $tipo
 */
class Objeto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objeto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','codigo', 'espacio_id', 'tipo_id'], 'required'],
            [['espacio_id', 'tipo_id'], 'integer'],
            [['nombre','codigo'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'nombre' => 'Nombre',
            'espacio_id' => 'Espacio',
            'tipo_id' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspacio()
    {
        return $this->hasOne(Espacio::className(), ['id' => 'espacio_id']);
    }

    public function getNombreEspacio() {
        return $this->espacio->nombre.' ('.$this->espacio->numeracion.')';
    }

    public function getEspacioList() 
	{	 
        $models = Espacio::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'numeracion','nombre');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoObjeto::className(), ['id' => 'tipo_id']);
    }
    
    public function getNombreTipo() {
        return $this->tipo->nombre;
    }
        public function getTipoObjetoList() 
	{	 
        $models = TipoObjeto::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
}
