<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Perfil $model */

$this->title = 'Actualizar el Perfil de: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="perfil-update">
    <div class="card no-border p-3 mb-3 mx-0">
        <h2 class="title-views m-0"><?= Html::encode($this->title) ?></h2>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
