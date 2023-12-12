<?php

namespace frontend\controllers;

use common\models\Reservas;
use common\models\ReservasArrendamiento;
use frontend\models\ReservasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;


/**
 * ReservasController implements the CRUD actions for Reservas model.
 */
class ReservasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Reservas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReservasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $modelRA = new ReservasArrendamiento();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelRA' => $modelRA,
        ]);
    }

    /**
     * Displays a single Reservas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reservas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reservas();

        if ($this->request->isPost) {
                // En el controlador de 'otro-modelo'
                $arrendamientoId = Yii::$app->request->post('arrendamiento_id');

            if ($model->load($this->request->post()) ) {
                
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', '¡Acabas de hacer una reserva!');
                    $model->reservaArrendamiento($arrendamientoId);
                }

            }
        } else {
            $model->loadDefaultValues();
        }
        // Redirige nuevamente a la vista 'view' del arrendamiento
        return $this->redirect(['arrendamiento/view', 'id' => $arrendamientoId]);
    }

    /**
     * Updates an existing Reservas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reservas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reservas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reservas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reservas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
