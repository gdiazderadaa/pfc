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
use yii\data\ActiveDataProvider;

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
    	$model = $this->findModel($id);
    	
    	// Set dataProvider for the related PlantaEdificio array
    	$plantasEdificioDataProvider = new ActiveDataProvider([
    			'query' => $model->getPlantasEdificio(),
    	]);
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'dataProvider' => $plantasEdificioDataProvider,
        ]);
    }
    
    /**
     * Displays the floors of a single Building model.
     * @param string $id
     * @return mixed
     */
    public function actionViewPlantas($id)
    {
    	// Set dataProvider for the related ValorCaracteristicaModeloComponenteHardware array
    	$query = PlantaEdificio::find()
    	->andFilterWhere(['edificio_id' => $id]);
    	$plantasDataProvider = new ActiveDataProvider([
    			'query' => $query,
    	]);
    
    	$model = $this->findModel($id);
    
    	return $this->renderAjax('view-plantas', [
    			'dataProvider' => $plantasDataProvider,
    			'model' => $model
    	]);
    }

    /**
     * Creates a new Edificio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Edificio();

        if ($model->load(Yii::$app->request->post())) {
            
            // process uploaded image file instance
            $image = $model->uploadImage();

            if ($model->save()) {
                DynamicRelations::relate($model, 'plantasEdificio', Yii::$app->request->post(), 'PlantaEdificio', PlantaEdificio::className());
                // upload only if valid uploaded file instance found
                if ($image !== false) {
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                 return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        else {
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
        $oldFile = $model->getImageFile();
        $oldImagenServidor = $model->imagen_servidor;
        $oldImagen = $model->imagen;

        if ($model->load(Yii::$app->request->post())) {
            
            if ($oldImagen != null && $model->imagen == "") {
                $model->deleteImage();
            }
            
            // process uploaded image file instance
            $image = $model->uploadImage();

            // revert back if no valid file instance uploaded
            if ($image === false) {
                $model->imagen_servidor = $oldImagenServidor;
                $model->imagen = $oldImagen;
            }
    
            if ($model->save()) {
                // upload only if valid uploaded file instance found
                if ($image !== false && ($oldFile==null || $oldFile != null && unlink($oldFile)) ) { // delete old and overwrite
                    $path = $model->getImageFile();
                    $image->saveAs($path);
                }
                
                DynamicRelations::relate($model, 'plantasEdificio', Yii::$app->request->post(), 'PlantaEdificio', PlantaEdificio::className());               
                $plantas = $model->getPlantasEdificio()->all(); 

                foreach ($plantas as $planta) {
                    $planta->uploadImageFromDynamicRelations();
                }
                return $this->redirect(['view', 'id'=>$model->id]);
            } else {
                // error in saving model
            }
        }
        return $this->render('update', [
            'model'=>$model,
        ]);   
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
            $model=$this->findModel($id);
            if ($model->delete()){
                 if (!$model->deleteImage()) {
                    Yii::$app->session->setFlash('error', Yii::t('app','Error deleting image'));
                }
            }       
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
