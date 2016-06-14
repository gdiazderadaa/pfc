<?php

namespace app\controllers;

use app\models\ActivoHardware;
use app\models\ActivoHardwareComponenteHardware;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ActivoHardwareComponenteHardwareController implements the CRUD actions for ActivoHardwareComponenteHardware model.
 */
class ActivoHardwareComponenteHardwareController extends Controller
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
        $model = new ActivoHardwareComponenteHardware();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $submit == false) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->refresh();
                Yii::$app->session->setFlash('success',Yii::t('app', 'The component has been attached successfully'));
                
                $parent = ActivoHardware::findOne($id);
                return $this->redirect(['/activo-hardware/view','id'=>$id]);
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        
        $parent = ActivoHardware::findOne($id);
        $model->activo_hardware_id = $parent->id;
    
        return $this->renderAjax('attach', [
            'model' => $model,
        ]);
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
        if (($model = ActivoHardwareComponenteHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
