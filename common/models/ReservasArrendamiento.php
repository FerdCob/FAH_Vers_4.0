<?php

namespace common\models;

use common\models\Arrendamiento;
use Yii;

/**
 * This is the model class for table "reservas_arrendamiento".
 *
 * @property int $id
 * @property int $reservas_id
 * @property int $arrendamiento_id
 *
 * @property Arrendamiento $arrendamiento
 * @property Reservas $reservas
 */
class ReservasArrendamiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas_arrendamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reservas_id', 'arrendamiento_id'], 'required'],
            [['reservas_id', 'arrendamiento_id'], 'integer'],
            [['arrendamiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrendamiento::class, 'targetAttribute' => ['arrendamiento_id' => 'id']],
            [['reservas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reservas::class, 'targetAttribute' => ['reservas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'reservas_id' => Yii::t('app', 'Reservas ID'),
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
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReservas()
    {
        return $this->hasOne(Reservas::class, ['id' => 'reservas_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservasArrendamientoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservasArrendamientoQuery(get_called_class());
    }
    
}
