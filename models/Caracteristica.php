<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caracteristica".
 *
 * @property string $id
 * @property string $nombre
 * @property string $unidades
 * @property string $tipo_activo
 *
 * @property ValorCaracteristicaActivoInventariable[] $valoresCaracteristicasActivoInventariable
 * @property ValorCaracteristicaModeloComponenteHardware[] $valoresCaracteristicasModeloComponenteHardware
 * @property ModeloComponenteHardware[] $modelosComponenteHardware
 */
class Caracteristica extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caracteristica';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Feature');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Features');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'tipo_activo'], 'required'],
            [['tipo_activo'], 'string'],
            [['nombre'], 'string', 'max' => 64],
            [['unidades'], 'string', 'max' => 16],
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
            'unidades' => Yii::t('app', 'Units'),
            'tipo_activo' => Yii::t('app', 'Asset Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasActivoInventariable()
    {
        return $this->hasMany(ValorCaracteristicaActivoInventariable::className(), ['caracteristica_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValoresCaracteristicasModeloComponenteHardware()
    {
        return $this->hasMany(ValorCaracteristicaModeloComponenteHardware::className(), ['caracteristica_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelosComponenteHardware()
    {
        return $this->hasMany(ModeloComponenteHardware::className(), ['id' => 'modelo_componente_hardware_id'])->viaTable('valor_caracteristica_modelo_componente_hardware', ['caracteristica_id' => 'id']);
    }
}
