<?php

namespace frontend\controllers;

use yii;
use common\models\Arrendamiento;
use common\models\Reservas;
use common\models\ServiciosArrendamientos;
use common\models\Fotos;
use frontend\models\ArrendamientoSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ArrendamientoController implements the CRUD actions for Arrendamiento model.
 */
class ArrendamientoController extends Controller
{
    public $searchModel;
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(), //Para hacer la validación de que el usuario este logiado en la aplicacion
                    'only' => ['view'], //Para mostrar informacion del controlador a usuarios invitados sin logiarse a a la aplicacion
                    'rules' => [ //Declarado alguna reglas de acceso
                        [
                            'allow' => true, //permite pasar a funciones que esten bloquedas a quienes este logiados a la aplicacion
                            'roles' => ['@']
                        ]
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'delete-image-id' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Arrendamiento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArrendamientoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Filtra por el ID del usuario actual
        $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);

        $propiedades = $dataProvider->getModels();

        return $this->render('index', [
            'propiedades' => $propiedades,
            'pagination' => $dataProvider->getPagination(),
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Arrendamiento model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = new Reservas();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelServicio' => $model,
        ]);
    }

    /**
     * Creates a new Arrendamiento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Arrendamiento();

        // Llamamos a getUserId para obtener el ID y asignarlo al modelo
        $userId = $this->getUserId();
        $model->user_id = $userId;



        //inicializamos la transaccion
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $model->loadUploadedImageFiles();
                    //este es una prueba de error, automaticamente se revierten los cambios
                    //descomentar para realizar manejo de errores
                    $servicios_ids = Yii::$app->request->post('Arrendamiento')['servicios_ids'];
                    //throw new \Exception('Error de validación del modelo.');

                    if ($model->save()) {
                        $model->saveImage();
                        $transaction->commit(); //aplicar cambios

                        $model->arrendamientoServicio($servicios_ids);
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        throw new \Exception('Error de validación del modelo.');
                    }
                }
            } else {
                $model->loadDefaultValues();
            }
            $transaction->rollBack(); //revertir cambios

        } catch (\Exception $e) {

            $transaction->rollBack();
            Yii::error($e->getMessage()); //se registra el error
            //se establece el mensaje de error
            $errorMessage = 'Se produjo un error al crear el arrendamiento. Por favor, verifica los datos y vuelve a intentarlo.';
            //se le establece un nombre
            $name = 'Error';

            return $this->render('..\site\error', [
                'name' => $name,  // Pasar $name a la vista
                'message' => $errorMessage,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    //Metodo para obtener el id del usuario que tienen inicio la sesion 
    public function getUserId()
    {
        $user = Yii::$app->user->identity;
        if ($user !== null) {
            return $user->id;
        } else {
            return null;
        }
    }

    /**
     * Updates an existing Arrendamiento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Verifica si el usuario actual es el propietario del registro
        if ($model->user_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException('No tienes permisos para realizar esta acción.');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->loadUploadedImageFiles();
            $serviciosSeleccionados = Yii::$app->request->post('Arrendamiento')['servicios_ids'];

            // Obtener los servicios ya asignados a este arrendamiento
            $serviciosActuales = ServiciosArrendamientos::find()->where(['arrendamiento_id' => $model->id])->all();
            $serviciosActualesIds = array_column($serviciosActuales, 'servicio_id');

            // Identificar nuevos servicios para asignar
            $nuevosServicios = array_diff($serviciosSeleccionados, $serviciosActualesIds);

            // Identificar servicios a desvincular
            $serviciosARemover = array_diff($serviciosActualesIds, $serviciosSeleccionados);

            if ($model->save()) {
                $model->saveImage();
                $model->arrendamientoServicio($nuevosServicios);
                ServiciosArrendamientos::deleteAll(['arrendamiento_id' => $model->id, 'servicio_id' => $serviciosARemover]);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Arrendamiento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $arrendamientoId = (int) $id;
        $model = $this->findModel($arrendamientoId);

        // Verificar si el usuario actual es el propietario del registro
        if ($model->user_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException('No tienes permisos para realizar esta acción.');
        }

        // Llamar al procedimiento almacenado para eliminar el arrendamiento
        $command = Yii::$app->db->createCommand('CALL eliminar_Arrendamiento(:arrendamiento_id)');
        $command->bindParam(':arrendamiento_id', $arrendamientoId, \PDO::PARAM_INT);
        $result = $command->queryOne();

        // Verificar el resultado del procedimiento almacenado
        if ($result['Mensaje'] == 'Arrendamiento eliminado correctamente') {
            Yii::$app->session->setFlash('success', 'Arrendamiento eliminado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', $result['Mensaje']);
        }

        return $this->redirect(['index']);
    }    public function actionDeleteImageId()
    {
        $image = Fotos::findOne($this->request->post('key'));
        if (!$image) {
            throw new NotFoundHttpException();
        }

        $filePath = Yii::getAlias('uploads/casas') . '/' . $image->nombre; // Corregir la ruta del archivo

        if ($image->delete()) {
            if (file_exists($filePath)) {
                unlink($filePath); // Elimina el archivo físico si existe
            } else {
                Yii::warning('El archivo no existe en la ruta: ' . $filePath, 'app'); // Puedes registrar un mensaje de advertencia si el archivo no existe
            }
            return json_encode(null);
        }

        return json_encode(['error' => true]);
    }
    //Nueva funcion para mostrar todos los registros disposable en el sistema
    public function actionHome() 
    {

        $query = Arrendamiento::find()->orderBy('titulo'); //Que busque todos los registros del modelo arrendamiento en la base de datos
    
        $pagination = new Pagination([ //Declaramos una paginacion para mostrar las casas en la vista 
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        $searchModel = new ArrendamientoSearch();
        $propiedades = $query->offset($pagination->offset)->limit($pagination->limit)->all(); //Establecemos los limites de acuerdo a la paginacion
        return $this->render('home', [ //Retornamos la vista con las propiedades de paginacion y registros en la base de datos
            'propiedades' => $propiedades,
            'pagination' => $pagination,
            'searchModel' => $searchModel,
        ]);
    }

    //Nueva funcion para buscar una propiedad por titulo
    public function actionSearch() {

        $searchModel = new ArrendamientoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $propiedades = $dataProvider->getModels();

        return $this->render('search', [
            'propiedades' => $propiedades,
            'pagination' => $dataProvider->getPagination(),
            'searchModel' => $searchModel,
        ]);
    }
    

    /**
     * Finds the Arrendamiento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Arrendamiento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Arrendamiento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}