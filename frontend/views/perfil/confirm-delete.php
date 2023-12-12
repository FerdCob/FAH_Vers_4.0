<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Confirmar Eliminación';

?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Por favor, ingresa tu contraseña para confirmar la eliminación de tu cuenta:</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'password')->passwordInput() ?>
<?php
// Espacio adicional para mover el botón hacia abajo
echo '<div style="margin-bottom: 20px;"></div>';
?>
<div class="form-group">
    <?= Html::submitButton('Confirmar', ['class' => 'btn btn-danger']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
// Espacio adicional para mover el botón hacia abajo
echo '<div style="margin-bottom: 20px;"></div>';
?>