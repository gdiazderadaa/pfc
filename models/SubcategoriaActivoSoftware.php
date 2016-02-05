<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subcategoria_activo_software".
 *
 * @property string $id
 * @property string $nombre
 *
 * @property ActivoSoftware[] $activoSoftwares
 */
class SubcategoriaActivoSoftware extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subcategoria_activo_software';
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
    public function getActivoSoftwares()
    {
        return $this->hasMany(ActivoSoftware::className(), ['subcategoria_activo_software_id' => 'id']);
    }
}
