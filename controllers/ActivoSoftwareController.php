<?php

namespace app\controllers;

use app\models\ActivoSoftware;
use app\models\ActivoSoftwareSearch;
use app\models\ValorCaracteristicaActivoInventariable;
use synatree\dynamicrelations\DynamicRelations;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


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
    	$model = $this->findModel($id);
    	 
    	// Set dataProvider for the related ValorCaracteristicaActivoInventariable array
    	$caracteristicas = new ActiveDataProvider([
    			'query' => $model->parent->getValoresCaracteristicasActivoInventariable(),
    	]);
    	
    	// Set dataProvider for the related ConfiguracionesActivoHardware array
    	$hardware = new ActiveDataProvider([
    			'query' => $model->getActivosHardware(),
    	]);
    	
    	
        return $this->render('view', [
            'model' => $model,
        	'caracteristicas' => $caracteristicas,
        	'hardware' => $hardware,
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
		
        $model->estado = "NA";
        
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
     * Clones an existing ActivoSoftware model.
     * If clone is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionClone($id)
    {
    	$model = new ActivoSoftware();
    	
    	$model->estado = "NA";
    
    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->id]);
    	} else {
    		$sourceModel = $this->findModel($id);
    		$model->attributes = $sourceModel->attributes;
    
    		//Clean unique properties or linked models
    		$model->codigo = null;
    
    		return $this->render('clone', [
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
	    	$model=$this->findModel($id);
	        if ($model->delete()){
	        	Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
	             		'modelClass' => $model->singularObjectName(),
	            ]));
            }  
        } catch (yii\db\IntegrityException $e) {
            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in some {modelClass2}', [
                                                            'modelClass' => $model->singularObjectName(),
                                                            'modelClass2' => \app\models\ActivoHardware::singularObjectName()
                ]));
            }
        }
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
