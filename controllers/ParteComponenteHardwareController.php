<?php

namespace app\controllers;

use Yii;
use app\models\ComponenteHardware;
use app\models\ParteComponenteHardware;
use app\models\ParteComponenteHardwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ParteComponenteHardwareController implements the CRUD actions for ParteComponenteHardware model.
 */
class ParteComponenteHardwareController extends Controller
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
     * Lists all ParteComponenteHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParteComponenteHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParteComponenteHardware model.
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
     * Creates a new ParteComponenteHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParteComponenteHardware();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ParteComponenteHardware model.
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
     * Deletes an existing ParteComponenteHardware model.
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
     * Attaches a hardware component to another (as a part).
     * If attachclone is successful, the browser will show a confirmation message
     * @param string $id
     * @param bool $submit
     * @return mixed
     */
    public function actionAttach($id, $submit = false)
    {       
        $model = new ParteComponenteHardware();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $submit == false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->refresh();
                Yii::$app->session->setFlash('success',Yii::t('app', 'The part has been attached successfully'));
                
                $parent = ComponenteHardware::findOne($id);
                return $this->redirect(['/componente-hardware/view','id'=>$id]);
                // Yii::$app->response->format = Response::FORMAT_JSON;
                // return [
                //     'message' => Yii::t('app','The part has been attached successfully'),
                // ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        
        $parent = ComponenteHardware::findOne($id);
        $model->componente_hardware_id = $parent->id;
    
        return $this->renderAjax('attach', [
            'model' => $model,
        ]);
    }
    
        /**
     * Attaches another hardware component to the given one.
     * If attach is successful, the browser will show a confirmation message
     * @param string $id
     * @param bool $submit
     * @return mixed
     */
    public function actionAttachChild($id, $submit = false)
    {       
        $model = new ParteComponenteHardware();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $submit == false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->refresh();
                Yii::$app->session->setFlash('success',Yii::t('app', 'The part has been attached successfully'));
                
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        else{
        	$parent = ComponenteHardware::findOne($id);
        	$model->componente_hardware_id = $parent->id;
        	
        	return $this->renderAjax('attach-child', [
        			'model' => $model,
        			'inventario' => $parent->modeloComponenteHardware->inventario
        	]);
        }     
        
    }

    /**
     * Finds the ParteComponenteHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ParteComponenteHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParteComponenteHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
