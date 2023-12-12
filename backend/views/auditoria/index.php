<?php

use backend\models\Auditoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\db\Query;

/** @var yii\web\View $this */
/** @var backend\models\AuditoriaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Auditorias');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auditoria-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // Mostrar el formulario de búsqueda
    echo $this->render('_search', ['model' => $searchModel]);

    // Mostrar una segunda tabla de solo usuarios
    echo GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => Auditoria::find()->select(['usuario'])->distinct(),
            'pagination' => false, // Desactivar la paginación
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'usuario',
            // Puedes agregar más columnas aquí según tus necesidades
        ],
    ]);

    // Mostrar la tabla de resultados de búsqueda solo si se ha enviado el formulario con datos
    if ($searchModel->load(Yii::$app->request->queryParams)) {
        // Validar el modelo y verificar si hay resultados
        if ($searchModel->validate() && $dataProvider->totalCount > 0) {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'fecha_hora',
                    'usuario',
                    'email:email',
                    //'titulo',
                    'precio',
                    'nombre_arrendamiento',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Auditoria $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]);
        } else {
            // No hay resultados
            echo 'No se encontraron resultados.';
        }

        // Nueva tabla basada en el mismo query
        $nuevaQuery = (new Query())
            ->select([
                //'id',
                'usuario',
                'email',
                'titulo',
                'nombre_arrendamiento',
                'tipo_operacion',
                'fecha_hora',
                'precio_antiguo',
            ])
            ->from('auditoria_delete') // Nombre de la nueva tabla
            //Eliminar las dos lineas siguientes para eliminar la subconsulta. 
            ->andWhere(['>', 'precio_antiguo', 0]) // Ajusta tu condición específica aquí
            ->andWhere(['<', 'precio_antiguo', (new Query())->select(['AVG(precio_antiguo)'])->from('auditoria_delete')]);


        $nuevaDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $nuevaQuery,
        ]);

        // Mostrar la nueva tabla
        if ($nuevaDataProvider->totalCount > 0) {
            echo '<h2>Eliminacion De Arrendamientos</h2>';
            echo GridView::widget([
                'dataProvider' => $nuevaDataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    'usuario',
                    'email',
                    'titulo',
                    'nombre_arrendamiento',
                    'tipo_operacion',
                    'fecha_hora',
                    'precio_antiguo',
                    // Agrega más columnas según sea necesario
                ],
            ]);
        } else {
            echo 'No se encontraron resultados en la nueva tabla.';
        }

        // Nueva tabla basada en el mismo query
        $nuevaQuery = (new Query())
            ->select([
                //'id',
                'usuario',
                'email',
                'titulo',
                'nombre_arrendamiento',
                'tipo_operacion',
                'fecha_hora',
                'precio_antiguo',
                'precio_nuevo',
            ])
            ->from('auditoria_update') // Nombre de la nueva tabla
            //Eliminar las dos lineas siguientes para eliminar la subconsulta. 
            ->andWhere(['>', 'precio_nuevo', 0]) // Ajusta tu condición específica aquí
            ->andWhere(['<', 'precio_nuevo', (new Query())->select(['AVG(precio_nuevo)'])->from('auditoria_update')]);


        $nuevaDataProvider = new \yii\data\ActiveDataProvider([
            'query' => $nuevaQuery,
        ]);

        // Mostrar la nueva tabla
        if ($nuevaDataProvider->totalCount > 0) {
            echo '<h2>Actualzación De Arrendamientos</h2>';
            echo GridView::widget([
                'dataProvider' => $nuevaDataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    'usuario',
                    'email',
                    'titulo',
                    'nombre_arrendamiento',
                    'tipo_operacion',
                    'fecha_hora',
                    'precio_antiguo',
                    'precio_nuevo',
                    // Agrega más columnas según sea necesario
                ],
            ]);
        } else {
            echo 'No se encontraron resultados en la nueva tabla.';
        }
    }
    ?>
</div>