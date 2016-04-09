<?php

namespace app\controllers;

use Yii;
use app\models\Edificio;
use app\models\EdificioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use synatree\dynamicrelations\DynamicRelations;
use app\models\PlantaEdificio;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * EdificioController implements the CRUD actions for Edificio model.
 */
class EdificioController extends Controller
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
     * Lists all Edificio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EdificioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Edificio model.
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
     * Creates a new Edificio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Espacio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'plantasEdificio', Yii::$app->request->post(), 'PlantaEdificio', PlantaEdificio::className());
            var_dump($_POST);
            die;
            // $plantaEdificio = ArrayHelper::getValue(Yii::$app->request->post(), 'PlantaEdificio');
            // if ($plantaEdificio != null)
            // {
            //     foreach ($variable as $key => $value) {
            //         # code...
            //     }
            // }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Edificio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'plantasEdificio', Yii::$app->request->post(), 'PlantaEdificio', PlantaEdificio::className());
            //$plantas = ArrayHelper::getValue(Yii::$app->request->post(), 'PlantaEdificio');
            $plantas = $model->getPlantasEdificio()->all(); 

            foreach ($plantas as $planta) {
                $planta->uploadImageFromDynamicRelations();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Edificio model.
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
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in some {modelClass2}', [
                'modelClass' => $model->singularObjectName(),
                'modelClass2' => $model->attributeLabels['planta_edificio_id'],
                ]));
                
                return $this->redirect(['index']);
            }
        }

        Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
            'modelClass' => $model->singularObjectName(),
        ]));
        
        if(! Yii::$app->request->isAjax){
                return $this->redirect(['index']);
        }
        else
        {
                return "OK";
        }
    }

    /**
     * Finds the Edificio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Edificio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Edificio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
