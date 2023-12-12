<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ReservaArrendamiento]].
 *
 * @see ReservaArrendamiento
 */
class ReservaArrendamientoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReservaArrendamiento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReservaArrendamiento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
