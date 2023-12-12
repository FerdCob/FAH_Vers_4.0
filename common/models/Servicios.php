<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servicios".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ServiciosArrendamientos[] $serviciosArrendamientos
 */
class Servicios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
        ];
    }

    /**
     * Gets query for [[ServiciosArrendamientos]].
     *
     * @return \yii\db\ActiveQuery|ServiciosArrendamientosQuery
     */
    public function getServiciosArrendamientos()
    {
        return $this->hasMany(ServiciosArrendamientos::class, ['servicio_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ServiciosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiciosQuery(get_called_class());
    }

    public function getNombre() {
        return $this->nombre;
    }
}
