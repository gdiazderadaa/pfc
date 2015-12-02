<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ActivoInventariable".
 *
 * @property string $ActivoInventariableID
 * @property string $Codigo
 * @property string $Nombre
 * @property string $FechaCompra
 * @property string $PrecioCompra
 *
 * @property ValorCaracteristicaActivo[] $valorCaracteristicaActivos
 * @property Caracteristica[] $caracteristicas
 */
class ActivoInventariable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ActivoInventariable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Codigo', 'Nombre', 'FechaCompra', 'PrecioCompra'], 'required'],
            [['FechaCompra'], 'safe'],
            [['PrecioCompra'], 'number'],
            [['Codigo'], 'string', 'max' => 128],
            [['Nombre'], 'string', 'max' => 64],
            [['Codigo'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ActivoInventariableID' => 'Activo Inventariable ID',
            'Codigo' => 'Codigo / Nº Serie',
            'Nombre' => 'Nombre',
            'FechaCompra' => 'Fecha Compra',
            'PrecioCompra' => 'Precio Compra',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorCaracteristicaActivos()
    {
        return $this->hasMany(ValorCaracteristicaActivo::className(), ['ActivoInventariableID' => 'ActivoInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['CaracteristicaID' => 'CaracteristicaID'])->viaTable('ValorCaracteristicaActivo', ['ActivoInventariableID' => 'ActivoInventariableID']);
    }
}
