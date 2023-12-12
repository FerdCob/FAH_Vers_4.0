<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servicios_arrendamientos".
 *
 * @property int $id
 * @property int $servicio_id
 * @property int $arrendamiento_id
 *
 * @property Arrendamiento $arrendamiento
 * @property Servicios $servicio
 */
class ServiciosArrendamientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicios_arrendamientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['servicio_id', 'arrendamiento_id'], 'required'],
            [['servicio_id', 'arrendamiento_id'], 'integer'],
            [['arrendamiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrendamiento::class, 'targetAttribute' => ['arrendamiento_id' => 'id']],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::class, 'targetAttribute' => ['servicio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'servicio_id' => Yii::t('app', 'Servicio ID'),
            'arrendamiento_id' => Yii::t('app', 'Arrendamiento ID'),
        ];
    }

    /**
     * Gets query for [[Arrendamiento]].
     *
     * @return \yii\db\ActiveQuery|ArrendamientoQuery
     */
    public function getArrendamiento()
    {
        return $this->hasOne(Arrendamiento::class, ['id' => 'arrendamiento_id']);
    }

    /**
     * Gets query for [[Servicio]].
     *
     * @return \yii\db\ActiveQuery|ServiciosQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicios::class, ['id' => 'servicio_id']);
    }

    /**
     * {@inheritdoc}
     * @return ServiciosArrendamientosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServiciosArrendamientosQuery(get_called_class());
    }
}
