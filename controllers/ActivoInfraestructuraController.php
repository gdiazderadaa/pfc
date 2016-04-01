<?php

namespace app\controllers;

use Yii;
use app\models\ActivoInfraestructura;
use app\models\ActivoInfraestructuraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use synatree\dynamicrelations\DynamicRelations;
use app\models\ValorCaracteristicaActivoInventariable;

/**
 * ActivoInfraestructuraController implements the CRUD actions for ActivoInfraestructura model.
 */
class ActivoInfraestructuraController extends Controller
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
     * Lists all ActivoInfraestructura models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivoInfraestructuraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivoInfraestructura model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ActivoInfraestructura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivoInfraestructura();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model->parent, 'valoresCaracteristicasActivoInventariable', Yii::$app->request->post(), 'ValorCaracteristicaActivoInventariable', ValorCaracteristicaActivoInventariable::className());
            return $this->redirect(['view', 'id' => $model->activo_inventariable_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ActivoInfraestructura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model->parent, 'valoresCaracteristicasActivoInventariable', Yii::$app->request->post(), 'ValorCaracteristicaActivoInventariable', ValorCaracteristicaActivoInventariable::className());
            return $this->redirect(['view', 'id' => $model->activo_inventariable_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ActivoInfraestructura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ActivoInfraestructura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ActivoInfraestructura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivoInfraestructura::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
