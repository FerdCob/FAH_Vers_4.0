<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[Auditoria]].
 *
 * @see Auditoria
 */
class AuditoriaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Auditoria[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Auditoria|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    //Subconsulta Auditoria: mayor al promedio por precio  
    public function registrosConPrecioSuperiorAlPromedio()
    {
        $subquery = (new \yii\db\Query())
            ->select(['id'])
            ->from('auditoria')
            ->where(['>', 'precio', 0]) // Ajusta tu condición específica aquí
            ->andWhere(['>', 'precio', (new \yii\db\Query())->select(['AVG(precio)'])->from('auditoria')]);

        return $this->andWhere(['in', 'id', $subquery]);
    }
}
