<?php

namespace app\controllers;

use Yii;
use app\models\ActivoSoftware;
use app\models\ActivoSoftwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use synatree\dynamicrelations\DynamicRelations;
use app\models\ValorCaracteristicaActivoInventariable;

/**
 * ActivoSoftwareController implements the CRUD actions for ActivoSoftware model.
 */
class ActivoSoftwareController extends Controller
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
     * Lists all ActivoSoftware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivoSoftwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivoSoftware model.
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
     * Creates a new ActivoSoftware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivoSoftware();

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
     * Updates an existing ActivoSoftware model.
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
     * Deletes an existing ActivoSoftware model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (yii\db\IntegrityException $e) {
            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in either some {modelClass2} or {modelClass3}', [
                                                            'modelClass' => ActivoSoftware::getSingularObjectName(),
                                                            'modelClass2' => 'hardware asset configuration',
                                                            'modelClass3' => 'feature',
                ]));
                
                return $this->redirect(['index']);
            }
        }

        Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
                                                        'modelClass' => 'software asset',
        ]));
        return $this->redirect(['index']);
    }

    /**
     * Finds the ActivoSoftware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ActivoSoftware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivoSoftware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
