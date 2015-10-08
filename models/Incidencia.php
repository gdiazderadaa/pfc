<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "incidencia".
 *
 * @property string $id
 * @property string $descripcion_breve
 * @property string $descripcion
 * @property integer $tipo_id
 * @property integer $impacto_id
 * @property integer $urgencia_id
 * @property integer $tecnico_id
 * @property integer $objeto_id
 * @property string $fecha_creacion
 * @property string $fecha_fin
 * @property integer $estado_id
 * @property integer $creador_id
 *
 * @property Accion[] $accions
 * @property User $creador
 * @property Estado $estado
 * @property Impacto $impacto
 * @property User $tecnico
 * @property TipoIncidencia $tipo
 * @property Urgencia $urgencia
 */
class Incidencia extends \yii\db\ActiveRecord
{
    const ID_MAX_LENGHT =15;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incidencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion_breve', 'tipo_id', 'impacto_id', 'urgencia_id', 'objeto_id', 'fecha_creacion', 'estado_id', 'creador_id'], 'required'],
            [['descripcion'], 'string'],
            [['tipo_id', 'impacto_id', 'urgencia_id', 'tecnico_id', 'objeto_id', 'estado_id', 'creador_id'], 'integer'],
            [['fecha_creacion', 'fecha_fin'], 'safe'],
            [['descripcion_breve'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion_breve' => 'Resumen',
            'descripcion' => 'Descripción',
            'tipo_id' => 'Categoría',
            'impacto_id' => 'Impacto',
            'urgencia_id' => 'Prioridad',
            'tecnico_id' => 'Técnico',
            'objeto_id' => 'Objeto',
            'fecha_creacion' => 'Fecha Creación',
            'fecha_fin' => 'Fecha Fin',
            'estado_id' => 'Estado',
            'creador_id' => 'Creador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccions()
    {
        return $this->hasMany(Accion::className(), ['incidencia_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'creador_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImpacto()
    {
        return $this->hasOne(Impacto::className(), ['id' => 'impacto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTecnico()
    {
        return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'tecnico_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoIncidencia::className(), ['id' => 'tipo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUrgencia()
    {
        return $this->hasOne(Urgencia::className(), ['id' => 'urgencia_id']);
    }
	
	    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjeto()
    {
        return $this->hasOne(Objeto::className(), ['id' => 'objeto_id']);
    }
	 public function getTipoList() 
	{	 
        $models = TipoIncidencia::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    public function getImpactoList() 
	{	 
        $models = Impacto::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    public function getUrgenciaList() 
	{	 
        $models = Urgencia::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    public function getObjetoList() 
	{	 
        $models = Objeto::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    public function getIdWithLeadingZeros()
    {
        $leadingZeros=$this::ID_MAX_LENGHT-strlen((string)$this->id);
        return 'INC'.str_pad($this->id,$leadingZeros,"0",STR_PAD_LEFT);
    }

}
