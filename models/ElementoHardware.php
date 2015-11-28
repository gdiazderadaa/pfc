<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ElementoHardware".
 *
 * @property string $ElementoHardwareID
 * @property string $NumeroSerie
 * @property string $Marca
 * @property string $Modelo
 * @property string $FechaCompra
 * @property string $PrecioCompra
 * @property string $SubcategoriaID
 * @property string $ActivoHardwareID
 *
 * @property SubcategoriaActivoHardware $subcategoria
 * @property ActivoHardware $activoHardware
 * @property ValorCaracteristicaElementoHardware[] $valorCaracteristicaElementoHardwares
 * @property Caracteristica[] $caracteristicas
 */
class ElementoHardware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ElementoHardware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NumeroSerie', 'Marca', 'Modelo', 'FechaCompra', 'PrecioCompra', 'SubcategoriaID', 'ActivoHardwareID'], 'required'],
            [['FechaCompra'], 'safe'],
            [['PrecioCompra'], 'number'],
            [['SubcategoriaID', 'ActivoHardwareID'], 'integer'],
            [['NumeroSerie', 'Marca'], 'string', 'max' => 128],
            [['Modelo'], 'string', 'max' => 256],
            [['NumeroSerie'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ElementoHardwareID' => 'Elemento Hardware ID',
            'NumeroSerie' => 'Numero Serie',
            'Marca' => 'Marca',
            'Modelo' => 'Modelo',
            'FechaCompra' => 'Fecha Compra',
            'PrecioCompra' => 'Precio Compra',
            'SubcategoriaID' => 'Subcategoria ID',
            'ActivoHardwareID' => 'Activo Hardware ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(SubcategoriaActivoHardware::className(), ['SubcategoriaActivoHardwareID' => 'SubcategoriaID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardware()
    {
        return $this->hasOne(ActivoHardware::className(), ['ActiovInventariableID' => 'ActivoHardwareID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValorCaracteristicaElementoHardwares()
    {
        return $this->hasMany(ValorCaracteristicaElementoHardware::className(), ['ElementoHardwareID' => 'ElementoHardwareID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicas()
    {
        return $this->hasMany(Caracteristica::className(), ['CaracteristicaID' => 'CaracteristicaID'])->viaTable('ValorCaracteristicaElementoHardware', ['ElementoHardwareID' => 'ElementoHardwareID']);
    }

    /**
     * @inheritdoc
     * @return ElementoHardwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ElementoHardwareQuery(get_called_class());
    }
}
