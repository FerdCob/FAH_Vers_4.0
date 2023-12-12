<?php

namespace common\models;

use Yii;
use common\models\ReservasArrendamiento;
use common\models\Arrendamiento;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property string $fecha
 * @property int $user_id
 *
 * @property ReservaArrendamiento[] $reservaArrendamientos
 * @property User $user
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'user_id'], 'required'],
            [['fecha'], 'safe'],
            [['fecha'], 'date', 'format'=>'Y-m-d'],
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * Gets query for [[ReservaArrendamientos]].
     *
     * @return \yii\db\ActiveQuery|ReservaArrendamientoQuery
     */
    public function getReservaArrendamientos()
    {
        return $this->hasMany(ReservaArrendamiento::class, ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public function getArrendamientos()
    {
        return $this->hasMany(Arrendamiento::className(), ['id' => 'arrendamiento_id'])
            ->viaTable('reservas_arrendamiento', ['reservas_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservasQuery(get_called_class());
    }
    public function reservaArrendamiento ($arrendamientoId) {

        $modelRA = new ReservasArrendamiento();
        $modelRA->arrendamiento_id = $arrendamientoId;
        $modelRA->reservas_id = $this->id;
        $modelRA->save();
    }
    public function getRelacion () {
        $model = new ReservasArrendamiento();
        
    }
}
