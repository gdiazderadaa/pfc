<?php

namespace app\controllers;

use Yii;
use app\models\ConfiguracionActivoHardware;
use app\models\ConfiguracionActivoHardwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfiguracionActivoHardwareController implements the CRUD actions for ConfiguracionActivoHardware model.
 */
class ConfiguracionActivoHardwareController extends Controller
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
     * Lists all ConfiguracionActivoHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfiguracionActivoHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConfiguracionActivoHardware model.
     * @param string $activo_hardware_id
     * @param string $activo_software_id
     * @return mixed
     */
    public function actionView($activo_hardware_id, $activo_software_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($activo_hardware_id, $activo_software_id),
        ]);
    }

    /**
     * Creates a new ConfiguracionActivoHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfiguracionActivoHardware();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'activo_hardware_id' => $model->activo_hardware_id, 'activo_software_id' => $model->activo_software_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ConfiguracionActivoHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $activo_hardware_id
     * @param string $activo_software_id
     * @return mixed
     */
    public function actionUpdate($activo_hardware_id, $activo_software_id)
    {
        $model = $this->findModel($activo_hardware_id, $activo_software_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'activo_hardware_id' => $model->activo_hardware_id, 'activo_software_id' => $model->activo_software_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ConfiguracionActivoHardware model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $activo_hardware_id
     * @param string $activo_software_id
     * @return mixed
     */
    public function actionDelete($activo_hardware_id, $activo_software_id)
    {
        $this->findModel($activo_hardware_id, $activo_software_id)->delete();

    	if(! Yii::$app->request->isAjax){
            return $this->redirect(['index']);
        }
        else
        {
            return "OK";
        }
    }

    /**
     * Finds the ConfiguracionActivoHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $activo_hardware_id
     * @param string $activo_software_id
     * @return ConfiguracionActivoHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($activo_hardware_id, $activo_software_id)
    {
        if (($model = ConfiguracionActivoHardware::findOne(['activo_hardware_id' => $activo_hardware_id, 'activo_software_id' => $activo_software_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
