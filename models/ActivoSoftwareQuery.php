<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivoSoftware]].
 *
 * @see ActivoSoftware
 */
class ActivoSoftwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ActivoSoftware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActivoSoftware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}