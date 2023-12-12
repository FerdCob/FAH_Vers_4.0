<?php

use common\models\Arrendamiento;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap5\Carousel;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ArrendamientoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Agregar nuevas propiedades');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arrendamiento-index">
<div class="card mb-3 no-border">
    <div class="card-header dashed-border-bottom">
        <h3 class="m-0 title-views"><?= Html::encode($this->title) ?></h3>
    </div>
        <div class="card-body d-flex justify-content-end">
            <p class="m-0">
                <?= Html::a(Yii::t('app', 'Agregar propiedad'), ['create'], ['class' => 'btn btn-custom1']) ?>
            </p>
        </div>
    </div>
    
<!--Declaramos un div para el contenedor principal-->
<div class="container-fluid mt-3">
    
    <h1 class="mb-3">Mis Propiedades</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        <!--foreach para iterar los archivos encontrados en la funcion del controlador de arrendamiento -->
        <?php foreach ($propiedades as $propiedad):?>
            <div class="col">
                <div class="card h-100 custom-card no-border">
                    <div class="image overflow-hidden" style="height: 12rem;">
                        <!--Accedemos ala funcion que se encuentra en el modelo de arrendamiento el cual nos recupera las imagenes en un arreglo y los visualiza en un carusel de boostrap-->
                        <?php
                        echo Carousel::widget([
                            'items' => $propiedad->carouselImages(),
                            'options' => ['class' => 'propiedad-view__carousel'],
                        ]);
                        ?>
                    </div>
                <div class="card-body">
                    <!--Accedemos alas propiedades del modelo arrendamiento para mostralos en las etiquetas html-->
                    <h5 class="card-title detalle_propiedad"><?= html::encode($propiedad->titulo)?></h5>

                    <div class="overflow-auto mb-3" style="height: 6rem;">
                        <p class="card-text text-muted over"><?= html::encode($propiedad->descripcion)?></p>
                    </div>
                        <p class="card-text m-0"><span class="fw-bold">Precio:</span> $<?= html::encode($propiedad->precio)?></p>
                        <p class="card-text"><span class="fw-bold">Categoria:</span> <?= html::encode($propiedad->categoria->nombre)?></p>
                    <div class="d-flex align-items-end">
                        <?= Html::a(Yii::t('app', 'Conocer más'), ['view', 'id' => $propiedad->id], ['class' => 'btn btn-custom2']) ?>
                    </div>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!--Etiqueta para la paginacion-->
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><?= LinkPager::widget(['pagination' => $pagination], ['class' => 'page-link'])?></li>
  </ul>
</nav>


</div>
