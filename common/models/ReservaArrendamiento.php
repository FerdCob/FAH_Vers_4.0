<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserva_arrendamiento".
 *
 * @property int $id
 * @property int $reserva_id
 * @property int $arrendamiento_id
 *
 * @property Arrendamiento $arrendamiento
 * @property Reservas $reserva
 */
class ReservaArrendamiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_arrendamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'arrendamiento_id'], 'required'],
            [['reserva_id', 'arrendamiento_id'], 'integer'],
            [['arrendamiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrendamiento::class, 'targetAttribute' => ['arrendamiento_id' => 'id']],
            [['reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reservas::class, 'targetAttribute' => ['reserva_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reserva_id' => Yii::t('app', 'Reserva ID'),
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
     * Gets query for [[Reserva]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReserva()
    {
        return $this->hasOne(Reservas::class, ['id' => 'reserva_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaArrendamientoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaArrendamientoQuery(get_called_class());
    }
}
