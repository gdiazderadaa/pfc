<?php

namespace app\controllers;

use Yii;
use synatree\dynamicrelations\DynamicRelations;
use app\models\ComponenteHardware;
use app\models\ComponenteHardwareSearch;
use app\models\ParteComponenteHardware;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * ComponenteHardwareController implements the CRUD actions for ComponenteHardware model.
 */
class ComponenteHardwareController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ComponenteHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComponenteHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider->pagination->pageSize = 10;
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComponenteHardware model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	// Set dataProvider for the related ComponenteHardware array
    	$componentesDataProvider = new ActiveDataProvider([
    			'query' => $model->getPartesComponenteHardware(),
    	]);
    	
        return $this->render('view', [
            'model' => $model,
        	'dataProvider' => $componentesDataProvider,
        ]);
    }
    
    public function actionSeriales()
    {
        $number = Yii::$app->request->post('number');
        return $this->renderAjax('seriales', [
            'number' => $number,
        ]);
    }

    /**
     * Creates a new ComponenteHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComponenteHardware();
        $model->scenario = 'Create';       
        
        
        
        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            
            $cantidad = Yii::$app->request->post('cantidad');
            if ($cantidad != null) {
                for ($i=0; $i < $cantidad - 1  ; $i++) {
                    $componente = new ComponenteHardware();
                    $componente->attributes = $model->attributes;
                    //TODO : Handle null inputs
                    $componente->numero_serie =  Yii::$app->request->post('ComponenteHardware')['serial-'.$i]; 
                    
                    if (!$componente->save()){
                        $transaction->rollBack();
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                    
                }
                $model->numero_serie =  Yii::$app->request->post('ComponenteHardware')['serial-'.$i]; 
                $model->modeloComponenteHardware->cantidad += $cantidad;
                $model->modeloComponenteHardware->save();
            }
            

            if ($model->save()){              
                DynamicRelations::relate($model, 'partesComponenteHardware', Yii::$app->request->post(), 'ParteComponenteHardware', ParteComponenteHardware::className());
                $transaction->commit();
                Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully created', [
                		'modelClass' => $cantidad > 1 ? $model->pluralObjectName() :$model->singularObjectName()
                ]));
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                 return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
        	$modelo_id = Yii::$app->request->get('modelo_componente_hardware_id');
        	if ($modelo_id != null) {
        		$model->modelo_componente_hardware_id = $modelo_id;
        	}
        	
            return $this->render('create', [
                'model' => $model,
            ]);
        }       
    }
    
    /**
     * Clones an existing ComponenteHardware model.
     * If clone is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionClone($id)
    {       
        $model = new ComponenteHardware();
        $model->scenario = 'Clone';
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $sourceModel = $this->findModel($id);
            $model->attributes = $sourceModel->attributes;
        
            //Clean unique properties or linked models
            $model->numero_serie = null;
            $model->activo_hardware_id = null;
            $model->isNewRecord = false;

            return $this->render('clone', [
                'model' => $model,
            ]);
        }
    }
       
    /**
     * Updates an existing ComponenteHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'Update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'partesComponenteHardware', Yii::$app->request->post(), 'ParteComponenteHardware', ParteComponenteHardware::className());
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ComponenteHardware model.
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
     * Finds the ComponenteHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ComponenteHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComponenteHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionEstados() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $modeloComponenteHardwareId = $parents[0];
                $out = ComponenteHardware::getEstadosByModelo($modeloComponenteHardwareId);
                $selected = $out[0]['id'];                

                echo Json::encode(['output'=>$out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionComponentesByModelo() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];            
            if ($parents != null) {
                $modelo_id = $parents[0];
                $out = ComponenteHardware::getComponentesByModelo($modelo_id); 
                if (sizeof($out) > 0) {
                    $selected = $out[0]['id'];  
                    echo Json::encode(['output'=>$out, 'selected'=>$selected]);
                } else {
                    echo Json::encode(['output'=>'', 'selected'=>'']);
                }
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}
