<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SubcategoriaActivoInfraestructura]].
 *
 * @see SubcategoriaActivoInfraestructura
 */
class SubcategoriaActivoInfraestructuraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SubcategoriaActivoInfraestructura[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SubcategoriaActivoInfraestructura|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}