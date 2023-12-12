<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Iniciar Sesion';
?>
<div class="container-login">
    <div class="site-login">
        <div class="card no-border">

            <div class="card-header p-3 dashed-border-bottom">
                <p class="mb-2"></p>
            </div>

            <div class="card-body"></div>

            <h3 class="text-center title-form-sing"><?= Html::encode($this->title) ?></h3>

            <p class="p-2 m-2 text-center text-muted">Complete los campos para iniciar</p>

            <div class="row m-3">

                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control input']) ?>

                    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control input']) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="my-1 mx-0" style="color:#999;">
                        If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    </div>

                    <div class="form-group pt-3">
                        <?= Html::submitButton('Iniciar', ['class' => 'btn btn-custom2 fw-bold', 'name' => 'login-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                
            </div>
        </div>

    </div>
</div>