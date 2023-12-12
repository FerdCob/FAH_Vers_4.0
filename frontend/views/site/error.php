<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error" style="display: flex; align-items: center;">

<div class="site-error" style="display: flex; align-items: center;">

    <div style="flex: 1;"> 
        <img src="<?= Yii::getAlias('@web')?>/uploads/tristeza.jpeg" alt="Imagen de error" class="img-responsive" style="max-width: 62%; height: auto;">
    </div>

    <div style="flex: 1; padding-left: 5px;"> 
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger" style="margin-bottom: 40px;">
            <?= nl2br(Html::encode($message)) ?>
        </div>
        <p style="text-align: left;">
            El error anterior ocurrió mientras el servidor Web estaba procesando su solicitud.
        </p>
        <p style="text-align: left;">
            Por favor contáctenos si piensa que es un problema del servidor. Gracias.
        </p>
    </div>

</div>
