<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\search\AuditoriaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="auditoria-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['onsubmit' => 'return preventEmptySubmit(this);'], // Agregamos esta línea
    ]); ?>

    <?= $form->field($model, 'usuario') ?>

    <div class="form-group">
        <?php
        // Mostrar botones solo si el formulario se ha enviado y tiene datos
        if ($model->load(Yii::$app->request->queryParams) && $model->validate() && !$model->isEmpty()) {
            echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']);
            echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- Agregamos el script de JavaScript -->
    <script>
        function preventEmptySubmit(form) {
            var inputs = form.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type === 'text' && inputs[i].value !== '') {
                    return true; // Permite la presentación del formulario si al menos un campo no está vacío
                }
            }
            return false; // Impide la presentación del formulario si todos los campos están vacíos
        }
    </script>
</div>