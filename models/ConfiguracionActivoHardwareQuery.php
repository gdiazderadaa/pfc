<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ConfiguracionActivoHardware]].
 *
 * @see ConfiguracionActivoHardware
 */
class ConfiguracionActivoHardwareQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ConfiguracionActivoHardware[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ConfiguracionActivoHardware|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}