<?php

use frontend\models\ArrendamientoSearch;
use yii\helpers\html;
use yii\widgets\LinkPager;
use yii\bootstrap5\Carousel;
use yii\debug\models\timeline\Search;
use yii\widgets\ActiveForm;

?>
<!--Declaramos un div para el contenedor principal-->
<div class="container-fluid mt-3">
    <div class="row mb-3">
        <div class="col-md-6"></div>

        <div class="col-md-6 d-flex justify-content-end">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['arrendamiento/search']]); 
            ?>
                <!--Boton de busqueda-->
                <div class="search">
                    <?= $form->field($searchModel, 'titulo')->textInput(['class' => 'form-control search__input'])->label(false);?>
                    <?= html::submitButton('buscar', ['class' => 'btn search_input'])?>
                </div>
                <!--Fin del boton de busqueda-->
                <?php ActiveForm::end(); ?>
        </div>
    </div>
    <h1 class="mb-3">Propiedades disponibles</h1>

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
                        <p class="card-text"><Span class="fw-bold">Precio:</Span> $<?= html::encode($propiedad->precio)?></p>
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