<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registro';
?>
<div class="container-signup">
    <div class="site-signup">

        <div class="card no-border shadow">
            <div class="card-header p-3 dashed-border-bottom">
                <p class="mb-2"></p>
            </div>
            <div class="card-body">

                <h2 class="text-center title-form-sing"><?= Html::encode($this->title) ?></h2>

                <p class="p-2 m-2 text-center text-muted">Complete todos los campos para registrarse</p>

                <div class="row m-3">
                    <div class="col-md-12">
                        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control input']) ?>

                            <?= $form->field($model, 'email')->textInput(['class' => 'form-control input']) ?>

                            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control input mb-2']) ?>
                            

                            <div class="form-group pt-3">
                                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-custom2', 'name' => 'signup-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        

        
    </div>
</div>

