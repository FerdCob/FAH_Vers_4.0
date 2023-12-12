<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;


use  common\models\PermisosHelpers;

use backend\assets\FontAwesomeAsset;
use common\models\User;

AppAsset::register($this);
FontAwesomeAsset::register($this);
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

        if (!Yii::$app->user->isGuest) {
            $es_admin = PermisosHelpers::requerirMinimoRol('Admin');

            $id_user = Yii::$app->user->identity->getId();
            $nombreRol = User::findOne(['id' => $id_user])->rol->rol_nombre;

            NavBar::begin([
                'brandLabel' => Html::img('@web/archivos/Logo1.png', ['alt' => 'Logo de la aplicación', 'class' => 'logo-image']),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-bg-custom fixed-top',
                    //navbar navbar-expand-md navbar-dark bg-dark fixed-top
                ],
            ]);
            $menuItems = []; // Se manejo este arreglo vacio para poder alinear a la derecha el menu en Backend
        } else {
            NavBar::begin([
                'brandLabel' => 'Sistema',            //Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-bg-custom fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
            ];
        }

        if (!Yii::$app->user->isGuest && $es_admin) {

            $id_user = Yii::$app->user->identity->getId();
            $nombreRol = User::findOne(['id' => $id_user])->rol->rol_nombre;
            $menuItems[] = [
                ['label' => $nombreRol],
                'label' => 'Inicio', 'url' => ['site/index'],
                'options' => ['class' => 'nav-link'],
                'template' => '<a href="{url}" class="item-links-nav">{label}</a>'
            ];

            $menuItems[] = [
                'label' => 'Registar una propiedad', 'url' => ['/site/index'],
                'options' => ['class' => 'nav-link'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
            ];

            $menuItems[] = [
                'label' => 'Mis propiedades', 'url' => ['/site/index'],
                'options' => ['class' => 'nav-link'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
            ];
            $menuItems[] = [
                'label' => 'Auditoria', 'url' => ['/auditoria/index'],
                'options' => ['class' => 'nav-link'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
            ];
            $menuItems[] = [
                'label' => 'Usuarios', 'url' => ['/user/index'],
                'options' => ['class' => 'nav-link'],
                'template' => '<a href="{url}" class="href_class">{label}</a>',
            ];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav mx-auto'],
            'items' => $menuItems,
        ]);

        if (Yii::$app->user->isGuest) {

            $menuItems[] = ['label' => 'Login', 'url' => ['site/login']];
        } else {
            $items = [
                '1' => 'Pefil',
                '2' => 'Salir',
            ];

            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar'])
                . Html::submitButton(
                    'Salir', // Nombre del campo
                    null, // Valor seleccionado
                    $items, // Opciones del menú desplegable
                    ['button' => '(' . Yii::$app->user->identity->username . ')', 'class' => 'btn btn-custom']
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

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy;
                <!-- <?= Html::encode('Sistema XXX') ?> -->
                <?= date('Y') ?>
                <spam></spam>Dr. Rusell Renan Iuit Manzanero
            </p>
            <!-- <p class="float-end"><?= Yii::powered() ?></p> -->
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
