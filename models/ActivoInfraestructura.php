<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;

/**
 * This is the model class for table "ActivoInfraestructura".
 *
 * @property string $ActivoInventariableID
 * @property string $SubcategoriaID
 *
 * @property SubcategoriaActivoInventariable $subcategoria
 */
class ActivoInfraestructura extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
{
    use ActiveRecordInheritanceTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ActivoInfraestructura';
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
            [['ActivoInventariableID', 'SubcategoriaID'], 'integer']
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
        return $this->hasOne(SubcategoriaActivoInfraestructura::className(), ['SubcategoriaActivoInfraestructuraID' => 'SubcategoriaID']);
    }
    
    public function getSubcategorias()
    {
       $models = SubcategoriaActivoInfraestructura::find()->asArray()->all();
        return ArrayHelper::map($models,'SubcategoriaActivoInfraestructuraID', 'Nombre'); 
    }
    

    /**
     * @inheritdoc
     * @return ActivoInfraestructuraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActivoInfraestructuraQuery(get_called_class());
    }
}
