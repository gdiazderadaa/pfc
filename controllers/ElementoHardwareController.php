<?php

namespace app\controllers;

use Yii;
use app\models\ElementoHardware;
use app\models\ElementoHardwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use synatree\dynamicrelations\DynamicRelations;
use app\models\ParteElementoHardware;
use app\models\ValorCaracteristicaElementoHardware;

/**
 * ElementoHardwareController implements the CRUD actions for ElementoHardware model.
 */
class ElementoHardwareController extends Controller
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
     * Lists all ElementoHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ElementoHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ElementoHardware model.
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
     * Creates a new ElementoHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ElementoHardware();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'valoresCaracteristicasElementoHardware', Yii::$app->request->post(), 'ValorCaracteristicaElementoHardware', ValorCaracteristicaElementoHardware::className());
            DynamicRelations::relate($model, 'partesElementoHardware', Yii::$app->request->post(), 'ParteElementoHardware', ParteElementoHardware::className());
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ElementoHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'valoresCaracteristicasElementoHardware', Yii::$app->request->post(), 'ValorCaracteristicaElementoHardware', ValorCaracteristicaElementoHardware::className());
            DynamicRelations::relate($model, 'partesElementoHardware', Yii::$app->request->post(), 'ParteElementoHardware', ParteElementoHardware::className());
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ElementoHardware model.
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
     * Finds the ElementoHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ElementoHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ElementoHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
