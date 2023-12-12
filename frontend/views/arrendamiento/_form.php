<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Servicios;


/** @var yii\web\View $this */
/** @var common\models\Arrendamiento $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="container-arrendamiento">
    <div class="arrendamiento-form">
        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'class' => 'form-control input']) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'precio')->textInput(['maxlength' => true, 'class' => 'form-control input']) ?>
            </div>
            
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <?= $form->field($model, 'descripcion')->textarea(['rows' => 6, 'class' => 'form-control textarea']) ?>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <?= $form->field($model, 'categoria_id')->widget(Select2::class, [
                    'data' => $model->Categorias, //Pasamos los registros que obtenemos de la tabla categoria con la funcion de getCategoría que esta declarada en el modelo arrendamiento
                    'options' => ['placeholder' => 'Seleccione una categoria  ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'servicios_ids[]')->widget(Select2::class, [
                        'data' => $model->Servicios, //Pasamos los registros que obtenemos de la tabla servicios con la funcion de getServicios que esta declarada en el modelo arrendamiento
                        'options' => ['placeholder' => 'Seleccione los servicios  ...',
                        'multiple' => true],
                        'value' => $model->serviciosAbsolute(), //Passamos la funcion que se creo en el modelo arrendamiento para obtener los servicios del arrendamiento
                        'pluginOptions' => [
                        'allowClear' => true],
                ]); ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <?= $form->field($model, 'imageFile[]')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*', 'multiple' => true],
                'pluginOptions' => [
                    'initialPreview' => $model->imageAbsoluteUrls(), //Passamos la funcion que se obtiene la url de la imagenes en la base de datos y las previsualiza cuando carga la vista 
                    'initialPreviewAsData' => true,
                    'showUpload' => false,
                    'deleteUrl' => Url::to(['arrendamiento/delete-image-id']),  //Le pasamos la funcion creada en el contrlador de arrendamiento para eliminar las imagenes al momento de actualizar
                    'initialPreviewConfig' => $model->imageConfigs(),

                    ]
                ]);?>
            </div>
        </div>

    <?= $form->field($model, 'user_id')->textInput(['value' => $model->user_id, 'readonly' => true, 'hidden'=>true]) ?>

    <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-custom2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>

