<?php

namespace app\controllers;

use Yii;
use app\models\ValorCaracteristicaActivo;
use app\models\ValorCaracteristicaActivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValorCaracteristicaActivoController implements the CRUD actions for ValorCaracteristicaActivo model.
 */
class ValorCaracteristicaActivoController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ValorCaracteristicaActivo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ValorCaracteristicaActivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ValorCaracteristicaActivo model.
     * @param string $CaracteristicaID
     * @param string $ActivoInventariableID
     * @return mixed
     */
    public function actionView($CaracteristicaID, $ActivoInventariableID)
    {
        return $this->render('view', [
            'model' => $this->findModel($CaracteristicaID, $ActivoInventariableID),
        ]);
    }

    /**
     * Creates a new ValorCaracteristicaActivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ValorCaracteristicaActivo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CaracteristicaID' => $model->CaracteristicaID, 'ActivoInventariableID' => $model->ActivoInventariableID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ValorCaracteristicaActivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $CaracteristicaID
     * @param string $ActivoInventariableID
     * @return mixed
     */
    public function actionUpdate($CaracteristicaID, $ActivoInventariableID)
    {
        $model = $this->findModel($CaracteristicaID, $ActivoInventariableID);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'CaracteristicaID' => $model->CaracteristicaID, 'ActivoInventariableID' => $model->ActivoInventariableID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ValorCaracteristicaActivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $CaracteristicaID
     * @param string $ActivoInventariableID
     * @return mixed
     */
    public function actionDelete($CaracteristicaID, $ActivoInventariableID)
    {
        $this->findModel($CaracteristicaID, $ActivoInventariableID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ValorCaracteristicaActivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $CaracteristicaID
     * @param string $ActivoInventariableID
     * @return ValorCaracteristicaActivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($CaracteristicaID, $ActivoInventariableID)
    {
        if (($model = ValorCaracteristicaActivo::findOne(['CaracteristicaID' => $CaracteristicaID, 'ActivoInventariableID' => $ActivoInventariableID])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
