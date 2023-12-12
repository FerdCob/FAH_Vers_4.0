<?php

use yii\helpers\Html;

use common\models\PermisosHelpers;

/**
 * @var yii\web\View $this
 * @var frontend\models\Perfil $model
 */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,500;1,400&family=Roboto:wght@100;500;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="perfil-view">
        <div class="row">
            <!-- Columna de la Foto de Perfil -->
            <div class="imagen col-md-6 text-center mt-4">
                <?php
                //uso del proceso almacenado
                $perfil = Yii::$app->db->createCommand('CALL consultar_perfil(:perfil_id)')
                    ->bindValue(':perfil_id', $model->id)
                    ->queryOne();
                $imagePath = Yii::getAlias('@web/uploads/') . $perfil['foto_es'];
                echo Html::img($imagePath, ['alt' => 'Perfil Image', 'class' => 'img-circle']);
                ?>
            </div>

            <!-- Columna de la Información del Perfil -->
            <div class="card no-border col-md-6 mt-3 p-3 shadow-sm">

                <div class="perfil-info text-center">
                    <!-- Titulo username-->
                    <p class="h4 text-center m-3"><?= Html::encode($this->title) ?></p>
                    <!-- Titulo Infor user-->
                    <strong class="display-4 fa-bold"><?= Html::encode($perfil['nombre_perfil']) ?></strong>
                    <span class="display-4 fa-bold"><?= Html::encode($perfil['apellido']) ?></span><br>
                    <!-- resto de info -->
                    <div class="lead text-body-secondary">
                        <strong>Fecha de Nacimiento:</strong> <?= Html::encode($perfil['fecha_nacimiento']) ?><br>
                        <strong>Género:</strong> <?= Html::encode($perfil['genero']) ?><br>
                        <strong>Fecha de Creación:</strong> <?= Html::encode($perfil['creado']) ?><br>
                        <strong>Última Actualización:</strong> <?= Html::encode($perfil['actualizado']) ?><br>
                    </div>
                </div>

                <div class="botones d-flex justify-content-center mt-3 ms-4">
                    <?php
                    if (PermisosHelpers::userDebeSerPropietario('perfil', $model->id)) {
                        echo Html::a('Actualizar', ['update', 'id' => $model->id], [
                            'type' => 'button',
                            'class' => 'btn btn-outline-primary rounded-pill btn-hover ',
                            'style' => '
                                    color:#000000;
                                    border: 1px dashed;
                                    margin-right: 30px;
                                ',
                        ]);
                    }
                    ?>
                    <?= Html::a('Eliminar Perfil', ['perfil/delete'], [
                        'class' => 'btn btn-outline-warning rounded-pill btn-hover',
                        'style' => 'border: 1px dashed;
                                    color:#000000;
                                    margin-right: 30px;
                        ',
                        'data' => [
                            'confirm' => '¿Estás seguro de que quieres eliminar tu perfil?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('Eliminar Cuenta', ['confirm-delete'], [
                        'class' => 'btn btn-outline-danger rounded-pill btn-hover',
                        'style' => 'border: 1px dashed; color: #000000;',
                    ]) ?>

                </div>

            </div>
        </div>
    </div>
</body>

</html>

<?php
// Enlace rel al archivo CSS externo
$this->registerCssFile(Yii::$app->request->baseUrl . '/css/perfil/view.css');
?>