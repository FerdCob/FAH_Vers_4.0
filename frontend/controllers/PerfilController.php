<?php

namespace frontend\controllers;

use frontend\models\Perfil;
use frontend\models\search\PerfilSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PermisosHelpers;
use common\models\RegistrosHelpers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use common\models\User; //  importar el modelo User
use frontend\models\ConfirmDeleteForm;


use yii;

/**
 * PerfilController implements the CRUD actions for Perfil model.
 */
class PerfilController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access'  =>  [
                    'class'  =>  \yii\filters\AccessControl::className(),
                    'only'  =>  ['index',  'view', 'create',  'update',  'delete'],
                    'rules'  =>  [
                        [
                            'actions'  =>  ['index',  'view', 'create',  'update',  'delete'],
                            'allow'  =>  true,
                            'roles'  =>  ['@'],
                        ],
                    ],
                ],

                'access2' => [
                    'class' => \yii\filters\AccessControl::className(),
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                return PermisosHelpers::requerirEstado('Activo');
                            }
                        ],

                    ],

                ],

                'verbs'  =>  [
                    'class'  =>  VerbFilter::className(),
                    'actions'  =>  [
                        'delete'  =>  ['post'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Perfil models.
     *
     * @return string
     */
    public  function  actionIndex()
    {
        if ($ya_existe  =  RegistrosHelpers::userTiene('perfil')) {
            return  $this->render('view',  [
                'model'  =>  $this->findModel($ya_existe),
            ]);
        } else {
            return  $this->redirect(['create']);
        }
    }

    /**
     * Displays a single Perfil model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public  function  actionView()
    {
        if ($ya_existe  =  RegistrosHelpers::userTiene('perfil')) {
            return  $this->render('view',  [
                'model'  =>  $this->findModel($ya_existe),
            ]);
        } else {
            return  $this->redirect(['create']);
        }
    }

    /**
     * Creates a new Perfil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new Perfil();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate()
    {
        $model = new Perfil();
        $model->user_id = \Yii::$app->user->identity->id;
        //Registros Helpers es una subconsulta esta en common\models\RegistrosHelpers
        if ($ya_existe = RegistrosHelpers::userTiene('perfil')) {
            return $this->render('view', [
                'model' => $this->findModel($ya_existe),
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->image_path = UploadedFile::getInstance($model, 'image_path');

            if ($model->validate()) {
                if ($model->image_path) {
                    $uploadPath = \Yii::getAlias('@frontend/web/uploads/');
                    $imageName = 'perfil_' . $model->user_id . '.' . $model->image_path->extension;
                    $model->image_path->saveAs($uploadPath . $imageName);
                    $model->image_path = $imageName;
                }

                if ($model->save()) {
                    return $this->redirect(['view']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perfil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionUpdate()
    {

        $transaction = Yii::$app->db->beginTransaction();

        try {
            PermisosHelpers::requerirUpgradeA('Pago');

            $model = Perfil::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

            if ($model) {

                if ($model->load(Yii::$app->request->post())) {
                    // Manejar la carga de la imagen
                    $model->image_path = UploadedFile::getInstance($model, 'image_path');
                    if ($model->validate()) {
                        try {
                            if ($model->image_path) {
                                // Guardar la imagen en la carpeta de uploads
                                $uploadPath = \Yii::getAlias('@frontend/web/uploads/');
                                $imageName = 'perfil_' . $model->user_id . '.' . $model->image_path->extension;
                                $model->image_path->saveAs($uploadPath . $imageName);
                                $model->image_path = $imageName;


                                Yii::$app->db->createCommand('CALL actualizar_perfil(:user_id, :nombre, :apellido, :fecha_nacimiento, :genero_id, :image_path)')
                                    ->bindValues([
                                        ':user_id' => $model->user_id,
                                        ':nombre' => $model->nombre,
                                        ':apellido' => $model->apellido,
                                        ':fecha_nacimiento' => $model->fecha_nacimiento,
                                        ':genero_id' => $model->genero_id,
                                        ':image_path' => $model->image_path,
                                    ])->execute();

                                $transaction->commit();
                                return $this->redirect(['view']);
                            } else {
                                throw new \Exception('Error de validación del modelo.');
                            }
                        } catch (\Exception $e) {
                            throw new \Exception('Error al llamar al procedimiento almacenado.');
                        }
                    } else {
                        throw new \Exception('Error de validación del modelo.');
                    }
                }
                $transaction->rollBack();

                return $this->render('update', [
                    'model' => $model,
                ]);
            } else {
                throw new NotFoundHttpException('No Existe el Perfil.');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage()); //se registra el error
            //se modifiestablece el mensaje de error
            $errorMessage = 'Se produjo un error al actualizar el perfil. Por favor, verifica los datos y vuelve a intentarlo.';
            //se le establece un nombre
            $name = 'Error';

            return $this->render('..\site\error', [
                'name' => $name,  // Pasar $name a la vista
                'message' => $errorMessage,
            ]);

            //return $this->render('..\site\error', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Deletes an existing Perfil model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    public function actionDelete()
    {
        try {
            // Buscar el perfil del usuario actual
            $model = Perfil::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

            if ($model) {
                $perfilId = $model->id;

                // Llamar al procedimiento almacenado para eliminar el perfil
                $connection = Yii::$app->db;
                $command = $connection->createCommand('CALL eliminar_perfil(:perfil_id)');
                $command->bindParam(':perfil_id', $perfilId);
                $result = $command->queryOne();

                Yii::$app->session->setFlash('success', $result['mensaje']);
            } else {
                Yii::$app->session->setFlash('error', 'No se encontró el perfil para el usuario actual.');
            }
        } catch (\Exception $e) {
            // Manejar la excepción según tus necesidades, por ejemplo, loguear el error
            Yii::error('Error en actionDelete: ' . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Error al eliminar el perfil.');
        }

        return $this->redirect(['site/index']);
    }

    public function actionDeleteUser()
    {
        try {
            // Obtener el ID del usuario actual
            $userId = Yii::$app->user->identity->id;

            // Llamar al procedimiento almacenado para eliminar el usuario
            $command = Yii::$app->db->createCommand('CALL eliminar_User(:usuario_id)');
            $command->bindParam(':usuario_id', $userId);
            $result = $command->queryOne();

            // Verificar el resultado del procedimiento almacenado
            if ($result && isset($result['Mensaje']) && $result['Mensaje'] === 'Usuario eliminado correctamente') {
                Yii::$app->session->setFlash('success', 'Usuario eliminado correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'El usuario no pudo ser eliminado.');
            }
        } catch (\Exception $e) {
            // Manejar la excepción según tus necesidades, por ejemplo, loguear el error
            Yii::error('Error en actionDeleteUser: ' . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Error al eliminar el usuario.');
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Verificacion doble al usuario.
     */
    public function actionConfirmDelete()
    {
        $model = new ConfirmDeleteForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Verificar la contraseña ingresada
            if ($this->verificarContraseña(Yii::$app->user->identity->id, $model->password)) {
                // Contraseña correcta, proceder con la eliminación
                return $this->redirect(['delete-user']);
            } else {
                // Contraseña incorrecta, mostrar un mensaje de error
                Yii::$app->session->setFlash('error', 'La contraseña ingresada es incorrecta.');
            }
        }

        return $this->render('confirm-delete', ['model' => $model]);
    }

    /**
     * Verificar la contraseña del usuario. SubConsulta - Verificación
     */
    protected function verificarContraseña($userId, $password)
    {
        $user = User::find()
            ->select(['id', 'password_hash']) // Asegúrate de seleccionar solo los campos necesarios
            ->where(['id' => $userId])
            ->one();

        if ($user && Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            return true;
        }

        return false;
    }


    /**
     * Finds the Perfil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Perfil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perfil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}