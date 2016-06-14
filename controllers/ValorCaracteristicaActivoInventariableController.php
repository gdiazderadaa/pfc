<?php

namespace app\controllers;

use Yii;
use app\models\ValorCaracteristicaActivoInventariable;
use app\models\ValorCaracteristicaActivoInventariableSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValorCaracteristicaActivoInventariableController implements the CRUD actions for ValorCaracteristicaActivoInventariable model.
 */
class ValorCaracteristicaActivoInventariableController extends Controller
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
     * Lists all ValorCaracteristicaActivoInventariable models.
     * @return mixed
     */
//     public function actionIndex()
//     {
//         $searchModel = new ValorCaracteristicaActivoInventariableSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single ValorCaracteristicaActivoInventariable model.
     * @param string $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new ValorCaracteristicaActivoInventariable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new ValorCaracteristicaActivoInventariable();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing ValorCaracteristicaActivoInventariable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing ValorCaracteristicaActivoInventariable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if(! Yii::$app->request->isAjax){
            return $this->redirect(['index']);
        }
        else
        {
            return "OK";
        }
    }

    /**
     * Finds the ValorCaracteristicaActivoInventariable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ValorCaracteristicaActivoInventariable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ValorCaracteristicaActivoInventariable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
