<?php
use yii\bootstrap5\Carousel;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\date\DatePicker;
use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;

$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', ['integrity' => 'sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN', 'crossorigin' => 'anonymous']);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['integrity' => 'sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL', 'crossorigin' => 'anonymous']);


/** @var yii\web\View $this */
/** @var common\models\Arrendamiento $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Arrendamientos'), 'url' => ['index']];
\yii\web\YiiAsset::register($this);
?>
<div class="arrendamiento-view">


    <p>
        <!--Verifica si es el mismo usuario el que esta navegando en la aplicacion-->
        <?php if ($model->user_id != Yii::$app->user->id): 

                echo Html::tag('span', '', ['class' => ' disabled', 'disabled' => true]);

        ?>
                
        <?php else: ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?php endif; ?>

        <?php if ($model->user_id != Yii::$app->user->id): 

                echo Html::tag('span', '', ['class' => ' disabled', 'disabled' => true]);

        ?>
                
        <?php else: ?>

                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>

        <?php endif; ?>

        
    </p>
    <div class="card no-border">
        <div class="card-header dashed-border-bottom">
            <h3>Detalles de la propiedad</h3>
        </div>
        <div class="card-body">
            <div class="row">

            <div class="col-md-6">
                <?php
            echo Carousel::widget([
                'items' => $model->carouselImages(),
                'options' => ['class' => 'project-view__carousel'],
            ]);
            ?>
            </div>

            <div class="col-md-6">
                <div class="row mb-3 row-view">
                    <h5 class="card-title"><?= Yii::t('app', 'Titulo') ?></h5>
                    <span class="detalle_propiedad"><?= $model->titulo?></span>
                </div>
                <div class="row mb-3">
                    <h5 class="card-title"><?= Yii::t('app', 'Descripcion') ?></h5>
                    <span class="detalle_propiedad"><?= $model->descripcion?></span>
                </div>
                <div class="row mb-3">
                    <h5 class="card-title"><?= Yii::t('app', 'Precio') ?></h5>
                    <span class="detalle_propiedad">$<?= $model->precio?></span>
                </div>
                <div class="row">
                    <h5 class="card-title"><?= Yii::t('app', 'Servicios') ?></h5>
                    <span class="detalle_propiedad"><?= implode(', ', $model->getServiciosSeleccionados());?></span>
                </div>

            </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <div  style="margin-top: 20px">
                    <?php
                    
                    $form = ActiveForm::begin([
                        'action' => ['reservas/create'], // Ajusta la acción del formulario según tus necesidades
                        'method' => 'post',
                    ]);
                    
                        Modal::begin([
                            'title' => 'Datepicker with other fields',
                            'toggleButton' => ['label' => 'Reservar un cita', 'class' => 'btn btn-custom2'],
                        ]);
                    ?>
                    <div class="row" style="margin-bottom: 8px">
                        <div class="col-sm-12">
                        <?= $form->field($modelServicio, 'fecha')->widget(DatePicker::classname(), [
                            'options' => ['placeholder' => 'Fecha de la reserva'],
                            
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'autoclose' => true
                            ]
                        ]);?>
                        <?= Html::hiddenInput('arrendamiento_id', $model->id) ?>
                        <?= $form->field($modelServicio, 'user_id')->textInput(['value' => Yii::$app->user->id, 'readonly' => true, 'hidden'=>true]) ?>
                        </div>
                    </div>
                    <?= Html::submitButton('Realizar la reserva', ['class' => 'btn btn-custom1']) ?>
                    <?php Modal::end();
                        ActiveForm::end();
                    ?>
                    </div>
                </div>
            </div>
            <!--FIn del modal de reserva-->
        </div>
    </div>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body">
            <?= Yii::$app->session->getFlash('success') ?>
            <div class="mt-2 pt-2 border-top">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
            </div>
        </div>
    </div>

    <script>
        var toast = new bootstrap.Toast(document.querySelector('.toast'));
        toast.show();
    </script>
<?php endif; ?>




</div>
