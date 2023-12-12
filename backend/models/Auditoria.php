<?php

namespace backend\models;

use Yii;
use backend\models\query\AuditoriaQuery;

/**
 * This is the model class for table "auditoria".
 *
 * @property int $id
 * @property string|null $fecha_hora
 * @property string|null $usuario
 * @property string|null $email
 * @property string|null $titulo
 * @property float|null $precio
 * @property string|null $nombre_arrendamiento
 */
class Auditoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auditoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_hora'], 'safe'],
            [['precio'], 'number'],
            [['usuario', 'email', 'titulo', 'nombre_arrendamiento'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha_hora' => Yii::t('app', 'Fecha Hora'),
            'usuario' => Yii::t('app', 'Usuario'),
            'email' => Yii::t('app', 'Email'),
            'titulo' => Yii::t('app', 'Titulo'),
            'precio' => Yii::t('app', 'Precio'),
            'nombre_arrendamiento' => Yii::t('app', 'Nombre Arrendamiento'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AuditoriaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuditoriaQuery(get_called_class());
    }
}
