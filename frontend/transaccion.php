public function actionUpdate()

{
    //iniciando transaccion
    $transaction = Yii::$app->db->beginTransaction();


    try {
        PermisosHelpers::requerirUpgradeA('Pago');

        //buscando el modelo
        $model = Perfil::find()->where(['user_id' => Yii::$app->user->identity->id])->one();


        if ($model) {
            if ($model->load(Yii::$app->request->post())) {
                // Resto del código...

                if ($model->save()) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            }

            // Resto del código...

            $transaction->rollBack();
        } else {
            throw new NotFoundHttpException('No Existe el Perfil.');
        }
    } catch (\Exception $e) {
        $transaction->rollBack();
        throw $e;
    }
}
