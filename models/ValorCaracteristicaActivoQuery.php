<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ValorCaracteristicaActivo]].
 *
 * @see ValorCaracteristicaActivo
 */
class ValorCaracteristicaActivoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ValorCaracteristicaActivo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ValorCaracteristicaActivo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}