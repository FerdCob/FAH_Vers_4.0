<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fotos".
 *
 * @property int $id
 * @property string $nombre
 * @property string $url
 * @property int $arrendamiento_id
 *
 * @property Arrendamiento $arrendamiento
 */
class Fotos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'url', 'arrendamiento_id'], 'required'],
            [['arrendamiento_id'], 'integer'],
            [['nombre', 'url'], 'string', 'max' => 255],
            [['arrendamiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arrendamiento::class, 'targetAttribute' => ['arrendamiento_id' => 'id']],
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
            'url' => Yii::t('app', 'Url'),
            'arrendamiento_id' => Yii::t('app', 'Arrendamiento ID'),
        ];
    }

    /**
     * Gets query for [[Arrendamiento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArrendamiento()
    {
        return $this->hasOne(Arrendamiento::class, ['id' => 'arrendamiento_id']);
    }
    //Metodo que recupera la url de la base de datos
    public function absoluteUrl() {
        return $this->url . '/' . $this->nombre;
    }
}
