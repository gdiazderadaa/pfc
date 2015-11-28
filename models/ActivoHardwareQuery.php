<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ActivoHardware]].
 *
 * @see ActivoHardware
 */
class ActivoHardwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ActivoHardware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ActivoHardware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}