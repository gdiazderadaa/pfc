<?php

namespace app\controllers;

use Yii;
use app\models\ValorCaracteristicaModeloComponenteHardware;
use app\models\ValorCaracteristicaModeloComponenteHardwareSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ValorCaracteristicaModeloComponenteHardwareController implements the CRUD actions for ValorCaracteristicaModeloComponenteHardware model.
 */
class ValorCaracteristicaModeloComponenteHardwareController extends Controller
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
     * Lists all ValorCaracteristicaModeloComponenteHardware models.
     * @return mixed
     */
//     public function actionIndex()
//     {
//         $searchModel = new ValorCaracteristicaModeloComponenteHardwareSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
//     }

    /**
     * Displays a single ValorCaracteristicaModeloComponenteHardware model.
     * @param string $id
     * @return mixed
     */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

    /**
     * Creates a new ValorCaracteristicaModeloComponenteHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//     public function actionCreate()
//     {
//         $model = new ValorCaracteristicaModeloComponenteHardware();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Updates an existing ValorCaracteristicaModeloComponenteHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

    /**
     * Deletes an existing ValorCaracteristicaModeloComponenteHardware model.
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
     * Finds the ValorCaracteristicaModeloComponenteHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ValorCaracteristicaModeloComponenteHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ValorCaracteristicaModeloComponenteHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionValoresByCaracteristica($q = null) {
        $query = new yii\db\Query;
        $query->select('valor')
            ->from('valor_caracteristica_modelo_componente_hardware')
            ->where('valor LIKE "%' . $q .'%"')
            ->orderBy('valor');
        $command = $query->createCommand();
        $data = $command->queryAll();

        $out = [];

        foreach ($data as $d) {
            $out[] = ['value' => $d['valor']];
        }
        
        echo Json::encode($out);
    }
}
