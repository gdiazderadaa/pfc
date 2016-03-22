<?php

namespace app\models;

use Yii;
use jlorente\db\ActiveRecordInheritanceTrait,
    jlorente\db\ActiveRecordInheritanceInterface;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activo_infraestructura".
 *
 * @property string $activo_inventariable_id
 * @property string $subcategoria_activo_infraestructura_id
 *
 * @property SubcategoriaActivoInfraestructura $subcategoriaActivoInfraestructura
 * @property ActivoInventariable $activoInventariable
 */
class ActivoInfraestructura extends \yii\db\ActiveRecord implements ActiveRecordInheritanceInterface
{
    use ActiveRecordInheritanceTrait; 
    
    public static function extendsFrom() {
        return ActivoInventariable::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activo_infraestructura';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Infrastructure Asset');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Infrastructure Assets');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo_inventariable_id', 'subcategoria_activo_infraestructura_id'], 'required'],
            [['activo_inventariable_id', 'subcategoria_activo_infraestructura_id'], 'integer'],
            [['activo_inventariable_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activo_inventariable_id' => Yii::t('app', 'Asset'),
            'subcategoria_activo_infraestructura_id' => Yii::t('app', 'Infrastructure Asset Subcategory'),
            'espacio_id' => Yii::t('app', 'Space'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoriaActivoInfraestructura()
    {
        return $this->hasOne(SubcategoriaActivoInfraestructura::className(), ['id' => 'subcategoria_activo_infraestructura_id']);
    }

    public function getSubcategorias() 
    { 
        $models = SubcategoriaActivoInfraestructura::find()->asArray()->all(); 
        return ArrayHelper::map($models,'id', 'nombre');  
    } 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivoInventariable()
    {
        return $this->hasOne(ActivoInventariable::className(), ['id' => 'activo_inventariable_id']);
    }
}
