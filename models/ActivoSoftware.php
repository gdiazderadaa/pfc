<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;

/**
 * This is the model class for table "ActivoSoftware".
 *
 * @property string $ActivoInventariableID
 * @property string $SubcategoriaID
 *
 * @property SubcategoriaActivoSoftware $subcategoria
 * @property ConfiguracionActivoHardware $configuracionActivoHardware
 * @property ActivoHardware[] $activoHardwares
 */
class ActivoSoftware extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
{
    use ActiveRecordInheritanceTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ActivoSoftware';
    }

    public static function extendsFrom() {
        return ActivoInventariable::className();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ActivoInventariableID', 'SubcategoriaID'], 'required'],
            [['ActivoInventariableID', 'SubcategoriaID'], 'integer'],
            [['ActivoInventariableID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ActivoInventariableID' => 'Activo Inventariable ID',
            'SubcategoriaID' => 'Subcategoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(SubcategoriaActivoSoftware::className(), ['SubcategoriaActivoSoftwareID' => 'SubcategoriaID']);
    }

    public function getSubcategorias()
    {
       $models = SubcategoriaActivoSoftware::find()->asArray()->all();
        return ArrayHelper::map($models,'SubcategoriaActivoSoftwareID', 'Nombre'); 
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracionActivoHardware()
    {
        return $this->hasOne(ConfiguracionActivoHardware::className(), ['ActivoSoftwareID' => 'ActivoInventariableID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoHardwares()
    {
        return $this->hasMany(ActivoHardware::className(), ['ActiovInventariableID' => 'ActivoHardwareID'])->viaTable('ConfiguracionActivoHardware', ['ActivoSoftwareID' => 'ActivoInventariableID']);
    }

    /**
     * @inheritdoc
     * @return ActivoSoftwareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivoSoftwareQuery(get_called_class());
    }
}
