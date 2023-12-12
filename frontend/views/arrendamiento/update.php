<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Arrendamiento $model */

$this->title = Yii::t('app', 'Actualizar propiedad "{name}" ', [
    'name' => $model->titulo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arrendamientos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="arrendamiento-update">
    <div class="card no-border mb-3 p-3">
        <h3 class="title-views m-0"><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
