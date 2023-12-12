<?php

namespace common\models;

use yii;
use yii\db\Query; // importar la clase Query aquí

/*
class RegistrosHelpers
{
    public static function userTiene($modelo_nombre)
    {
        $conexion = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $modelo_nombre WHERE user_id=:userid";
        $comando = $conexion->createCommand($sql);
        $comando->bindValue(":userid", $userid);
        $resultado = $comando->queryOne();
        if ($resultado == null) {
            return false;
        } else {
            return $resultado['id'];
        }
    }
}*/

class RegistrosHelpers
{
    public static function userTiene($modelo_nombre)
    {
        $userId = Yii::$app->user->identity->id;

        return (new Query())
            ->select('id')
            ->from($modelo_nombre)
            ->where(['user_id' => $userId])
            ->scalar();
    }
}