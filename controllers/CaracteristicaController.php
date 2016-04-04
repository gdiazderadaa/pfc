<?php

namespace app\controllers;

use Yii;
use app\models\Caracteristica;
use app\models\CaracteristicaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CaracteristicaController implements the CRUD actions for Caracteristica model.
 */
class CaracteristicaController extends Controller
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
     * Lists all Caracteristica models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CaracteristicaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Caracteristica model.
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
     * Creates a new Caracteristica model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Caracteristica();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    

    /**
     * Updates an existing Caracteristica model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Caracteristica model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        
        try {
            $this->findModel($id)->delete();
        } catch (yii\db\IntegrityException $e) {
            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in some {modelClass2}', [
                'modelClass' => 'feature',
                'modelClass2' => 'asset',
                ]));
                
                return $this->redirect(['index']);
            }
        }

        Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
            'modelClass' => 'feature',
        ]));
    }

    /**
     * Finds the Caracteristica model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Caracteristica the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Caracteristica::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
