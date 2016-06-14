<?php

namespace app\controllers;

use Yii;
use app\models\ActivoHardware;
use app\models\ActivoHardwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use synatree\dynamicrelations\DynamicRelations;
use app\models\ConfiguracionActivoHardware;
use yii\data\ActiveDataProvider;


/**
 * ActivoHardwareController implements the CRUD actions for ActivoHardware model.
 */
class ActivoHardwareController extends Controller
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
     * Lists all ActivoHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivoHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ActivoHardware model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
    	
        // Set dataProvider for the related ConfiguracionActivoHardware array
        $configuracionesDataProvider = new ActiveDataProvider([
            'query' => $model->getConfiguracionesActivoHardware(),
        ]);
        
        // Set dataProvider for the related ConfiguracionActivoHardware array
        $componentesDataProvider = new ActiveDataProvider([
        		'query' => $model->getComponentesHardware(),
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'configuraciones' => $configuracionesDataProvider,
        	'componentes' => $componentesDataProvider,
        ]);
    }

    /**
     * Creates a new ActivoHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivoHardware();
               
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'configuracionesActivoHardware', Yii::$app->request->post(), 'ConfiguracionActivoHardware', ConfiguracionActivoHardware::className());
            return $this->redirect(['view', 'id' => $model->activo_inventariable_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Clones an existing ActivoHardware model.
     * If clone is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionClone($id)
    {
    	$model = new ActivoHardware();
    	
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		DynamicRelations::relate($model, 'configuracionesActivoHardware', Yii::$app->request->post(), 'ConfiguracionActivoHardware', ConfiguracionActivoHardware::className());
    		return $this->redirect(['view', 'id' => $model->id]);
    	} else {
    		$sourceModel = $this->findModel($id);
    		$model->attributes = $sourceModel->attributes;
    
    		//Clean unique properties
    		$model->codigo = null;
    
    		//Enable select2 to be initialized
    		$model->isNewRecord = false;
    
    		return $this->render('clone', [
    				'model' => $model,
    		]);
    	}
    }
    
    /**
     * Updates an existing ActivoHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
               
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'configuracionesActivoHardware', Yii::$app->request->post(), 'ConfiguracionActivoHardware', ConfiguracionActivoHardware::className());
            return $this->redirect(['view', 'id' => $model->activo_inventariable_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ActivoHardware model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
        		'modelClass' => \app\models\ActivoHardware::singularObjectName(),
        ]));
        return $this->redirect(['index']);
    }

    /**
     * Finds the ActivoHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ActivoHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivoHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
