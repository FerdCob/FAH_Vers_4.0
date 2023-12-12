<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;  //use  yii\widgets\Breadcrumbs;
use yii\bootstrap5\Html;         //use  yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use frontend\assets\FontAwesomeAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
            'brandLabel' => Html::img('@web/archivos/Logo1.png', ['alt' => 'Logo de la aplicación', 'class' => 'logo-image']),
            'brandUrl' => ['arrendamiento/home'],
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-custom fixed-top',
                ],
        ]);
    
    $menuItems = [

        ['label' => 'Inicio', 'url' => ['/arrendamiento/home'],
        'options' =>['class' =>'nav-link']],
        
        (!Yii::$app->user->isGuest) ? (
        ['label' => 'Agregar propiedades', 'url' => ['/arrendamiento/create'],
        'options' =>['class' =>'nav-link']] ) : (""),

        (!Yii::$app->user->isGuest) ? (
        ['label' => 'Mis propiedades', 'url' => ['/arrendamiento/index'],
        'options' =>['class' =>'nav-link']] ) : ("")
        
    ];
    if (Yii::$app->user->isGuest) {
        //$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        //$menuItems[]  =  ['label'  =>  'Signup',  'url'  =>  ['/site/signup']];  //Se agrego
        //$menuItems[]  =  ['label'  =>  'Login',  'url'  =>  ['/site/login']];    //Se agrego

        echo Html::a('Registrarse',['/site/signup'],['class' => ['btn btn-custom-hover-nav']]);
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);

    } else {
        echo Html::a('Reservas',['/reservas/index'],['class' => ['btn btn-link login text-decoration-none']]);
        echo Html::tag('div',Html::a('Perfil',['/perfil/view'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
        
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Salir (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<div class="px-md-3">
    <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 py-5 mt-5 border-top justify-content-center bg-body-tertiary">
        <div class="col">
        <a class="d-inline-flex align-items-center mb-2 text-body-emphasis text-decoration-none" href="/" >
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="" class="d-block me-2" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M346.3 271.8l-60.1-21.9L214 448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H544c17.7 0 32-14.3 32-32s-14.3-32-32-32H282.1l64.1-176.2zm121.1-.2l-3.3 9.1 67.7 24.6c18.1 6.6 38-4.2 39.6-23.4c6.5-78.5-23.9-155.5-80.8-208.5c2 8 3.2 16.3 3.4 24.8l.2 6c1.8 57-7.3 113.8-26.8 167.4zM462 99.1c-1.1-34.4-22.5-64.8-54.4-77.4c-.9-.4-1.9-.7-2.8-1.1c-33-11.7-69.8-2.4-93.1 23.8l-4 4.5C272.4 88.3 245 134.2 226.8 184l-3.3 9.1L434 269.7l3.3-9.1c18.1-49.8 26.6-102.5 24.9-155.5l-.2-6zM107.2 112.9c-11.1 15.7-2.8 36.8 15.3 43.4l71 25.8 3.3-9.1c19.5-53.6 49.1-103 87.1-145.5l4-4.5c6.2-6.9 13.1-13 20.5-18.2c-79.6 2.5-154.7 42.2-201.2 108z"/></svg>                  
                    <span class="fs-5">For a Home</span>
        </a>

        <p class="text-muted"> 
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae eaque est, dolores hic praesentium delectus id
        </P>
        <p class="text-muted"> 
            <span> © <?= date('Y')?> FaH Industries, Inc</span>
        </p>
        </div>

        
        <div class="col">
        <h5>Links</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Home</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Features</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Pricing</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">FAQs</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">About</a></li>
        </ul>
        </div>

        <div class="col">
        <h5>Developers</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Oscar Alexander Caamal Dzib</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Luis Fernando Coboj Olivarez</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Fernando Jose Uc Poot </a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Yahir Ademar Gongora Dzul</a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Marco Antonio Cervera Poot</a></li>
        </ul>
        </div>

        <div class="col">
        <h5>Docs</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;">Dr. Rusell Renan Iuit Manzanero </a></li>
            <li class="nav-item mb-2"><a href="#" class="p-0 text-muted" style="text-decoration:none;"><?= Yii::powered() ?></a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted"> 
                <a class="d-inline-flex align-items-center mb-2 text-body-emphasis text-decoration-none" href="/" aria-label="Bootstrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="" class="d-block me-2" viewBox="0 0 118 94" role="img"><title>Bootstrap</title><path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path></svg>
                    <span class="fs-5">Bootstrap</span>
                </a>
            </li>
            
        </ul>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
