<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubcategoriaActivoHardware]].
 *
 * @see SubcategoriaActivoHardware
 */
class SubcategoriaActivoHardwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SubcategoriaActivoHardware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoHardware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}