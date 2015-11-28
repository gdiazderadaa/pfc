<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubcategoriaActivoSoftware]].
 *
 * @see SubcategoriaActivoSoftware
 */
class SubcategoriaActivoSoftwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SubcategoriaActivoSoftware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoSoftware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}