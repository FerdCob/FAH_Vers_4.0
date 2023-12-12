<?php

namespace common\models;

use common\models\ValorHelpers;

use yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\db\Query; // importar la clase Query aquí

class PermisosHelpers
{
    /*
    public static function requerirUpgradeA($tipo_usuario_nombre)
    {
        $userId = Yii::$app->user->identity->id;

        $tipoUsuarioCoincide = (new Query())
            ->select('id')
            ->from('usuario')
            ->where(['id' => $userId, 'tipo_usuario' => $tipo_usuario_nombre])
            ->exists();

        if (!$tipoUsuarioCoincide) {
            return Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
        }
    }
*/

    public static function requerirUpgradeA($tipo_usuario_nombre)
    {
        if (!ValorHelpers::tipoUsuarioCoincide($tipo_usuario_nombre)) {
            return Yii::$app->getResponse()->redirect(Url::to(['upgrade/index']));
        }
    }
    public static function requerirEstado($estado_nombre)
    {
        return ValorHelpers::estadoCoincide($estado_nombre);
    }
    public static function requerirRol($rol_nombre)
    {
        return ValorHelpers::rolCoincide($rol_nombre);
    }
    public static function requerirMinimoRol($rol_nombre, $userId = null)
    {
        if (ValorHelpers::esRolNombreValido($rol_nombre)) {
            if ($userId == null) {
                $userRolValor = ValorHelpers::getUsersRolValor();
            } else {
                $userRolValor = ValorHelpers::getUsersRolValor($userId);
            }
            return $userRolValor >= ValorHelpers::getRolValor($rol_nombre) ? true : false;
        } else {
            return false;
        }
    }

    public static function userDebeSerPropietario($model_nombre, $model_id)
    {
        $userId = Yii::$app->user->identity->id;

        $esPropietario = (new Query())
            ->select('id')
            ->from($model_nombre)
            ->where(['user_id' => $userId, 'id' => $model_id])
            ->exists();

        return $esPropietario;
    }

    /*
    public static function userDebeSerPropietario($model_nombre, $model_id)
    {
        $connection = \Yii::$app->db;
        $userid = Yii::$app->user->identity->id;
        $sql = "SELECT id FROM $model_nombre WHERE user_id=:userid AND id=:model_id";
        $command = $connection->createCommand($sql);
        $command->bindValue(":userid", $userid);
        $command->bindValue(":model_id", $model_id);
        if ($result = $command->queryOne()) {
            return true;
        } else {
            return false;
        }
    }
*/
}