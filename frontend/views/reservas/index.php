<?php

use common\models\Reservas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\ReservasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Mis reservas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservas-index">
    <div class="card mb-3 no-border">
        <div class="card-header dashed-border-bottom">
            <h3 class="m-0 title-views"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fecha',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reservas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
        </div>
    </div>

    


</div>