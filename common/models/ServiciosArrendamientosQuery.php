<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ServiciosArrendamientos]].
 *
 * @see ServiciosArrendamientos
 */
class ServiciosArrendamientosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ServiciosArrendamientos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ServiciosArrendamientos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
