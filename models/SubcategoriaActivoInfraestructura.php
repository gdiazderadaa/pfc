<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcategoria_activo_infraestructura".
 *
 * @property string $id
 * @property string $nombre
 *
 * @property ActivoInfraestructura[] $activosInfraestructura
 */
class SubcategoriaActivoInfraestructura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subcategoria_activo_infraestructura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 128],
            [['nombre'], 'unique']
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivosInfraestructura()
    {
        return $this->hasMany(ActivoInfraestructura::className(), ['subcategoria_activo_infraestructura_id' => 'id']);
    }
}
