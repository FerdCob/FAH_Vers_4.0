<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use  yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perfil */
/* @var $form yii\widgets\ActiveForm */
?>
<head>
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>../web/css/perfil/form-update.css">
</head>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="perfil-form shadow d-flex">

    <div class="cuadro-morado rounded-start-3 d-none d-lg-block">
        <div class="cont-morado ">

                <h1 class="fah text-start">
                    For a Home
                </h1>

                <div class="icon-edit d-flex" style="margin-top:25%;">
                    <img src="<?= Yii::$app->urlManager->baseUrl ?>/uploads/img_css/girl-on-desk.png" alt="" height="350">
                </div>
        </div>
    </div>

    <div class="card my-3 mx-5">
        <div class="card-header text-center p-4">
            <!-- Header -->
        </div>
            <!-- Contenido form -->
        <div class="card-body text-start p-3">

            <div class="img-perfil mb1 d-flex justify-content-center">
                <img class="rounded-2" id="preview" src="#" alt="Vista previa de la imagen" style="display: none;">
            </div>

            <div class="mb-1 d-flex">
                <div class="flex-grow-1 me-2">
                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => 45, 'class' => 'form-control input mt-2']) ?>
                </div>
                <div class="flex-grow-1 ms-2">
                    <?= $form->field($model, 'apellido')->textInput(['maxlength' => 45, 'class' => 'form-control input mt-2']) ?>
                </div>
            </div>
    
            <div class="mb-1">
                <?= $form->field($model, 'fecha_nacimiento')->widget(
                    DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'clientOptions' => [
                            'yearRange' => '-115:+0',
                            'changeYear' => true,
                        ],
                        'options' => ['class' => 'form-control  input mt-2'], 
                    ]
                ) ?>
            </div>

            <div class="mb-1">
                <?= $form->field($model, 'genero_id')->dropDownList($model->generoLista, ['prompt' => 'Seleccione el genero', 'class' => 'form-control select mt-2']) ?>
            </div>

            <div class="my-2">
                <div class="image-container bg-body-tertiary rounded-2 d-flex justify-content-center text-center" style="border: 1px dashed #ccc; padding-top: 10px;">
                    <div style="cursor: pointer;" onclick="seleccionarArchivo()">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(75, 85, 99, 1);" height="30px"viewBox="0 0 24 24"><g stroke-width="0" id="SVGRepo_bgCarrier"></g><g stroke-linejoin="round" stroke-linecap="round" id="SVGRepo_tracerCarrier"></g><g id="SVGRepo_iconCarrier"> <path fill="" d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" clip-rule="evenodd" fill-rule="evenodd"></path> </g></svg>
                    <p>
                        Click me to add image
                    </p>
                    </div>

                    <?= $form->field($model, 'image_path', [
                        'options' => ['class' => 'hidden-input'], //  clase oculta
                        'labelOptions' => ['style' => 'display:none;'],
                    ])->fileInput([
                        'class' => 'file-input', 
                        'id' => 'file-input',
                        'onchange' => 'actualizarVistaPrevia(this); mostrarNombreArchivo(this);',
                    ]) ?>
                </div>

            </div>

            <div class="form-group d-grid gap-2">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'boton-sg btn btn-outline' : 'boton-sg btn btn-outline']) ?>
                    </div>
            <?php ActiveForm::end(); ?>

        </div>
        
        <div class="card-footer text-center text-body-secondary p-4">
            
        </div>
            
            
     </div>
        
        


</div>


<script>
    var imagenSeleccionada = '<?= $model->image_path ?? '' ?>';

    function seleccionarArchivo() {
        // Simular clic en el input de archivo cuando se hace clic en el contenedor
        document.querySelector('.hidden-input input[type="file"]').click();
    }

    function previsualizarImagen(input) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // Muestra la vista previa de la imagen
            document.getElementById('preview').style.display = 'block';
            document.getElementById('preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }

    function mostrarNombreArchivo(input) {
        // Mostrar el nombre del archivo seleccionado o un string vacío si no se selecciona ninguno
        var fileName = input.files.length > 0 ? input.files[0].name : "";
        alert('Imagen seleccionada: ' + fileName);
    }

    function actualizarVistaPrevia(input) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('preview').style.display = 'block';
            document.getElementById('preview').src = e.target.result;
            // Almacena el nombre de la imagen seleccionada
            imagenSeleccionada = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }

    // Antes de enviar el formulario, verifica si se ha seleccionado un nuevo archivo
    // Llena la vista previa con la imagen actual del usuario al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        if (imagenSeleccionada) {
            document.getElementById('preview').style.display = 'block';
            document.getElementById('preview').src = '<?= Yii::$app->urlManager->baseUrl ?>/uploads/' + imagenSeleccionada;
        }
    });
</script>
