<?php

namespace app\controllers;

use app\models\ComponenteHardware;
use app\models\ModeloComponenteHardware;
use app\models\ModeloComponenteHardwareSearch;
use app\models\ValorCaracteristicaModeloComponenteHardware;
use synatree\dynamicrelations\DynamicRelations;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ModeloComponenteHardwareController implements the CRUD actions for ModeloComponenteHardware model.
 */
class ModeloComponenteHardwareController extends Controller
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
     * Lists all ModeloComponenteHardware models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModeloComponenteHardwareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ModeloComponenteHardware model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	
        // Set dataProvider for the related ValorCaracteristicaModeloComponenteHardware array
        $caracteristicasDataProvider = new ActiveDataProvider([
            'query' => $model->getValoresCaracteristicasModeloComponenteHardware(),
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $caracteristicasDataProvider,
        ]);
    }
    
    /**
     * Displays the features of a single ModeloComponenteHardware model.
     * @param string $id
     * @return mixed
     */
    public function actionViewCaracteristicas($id)
    {
        // Set dataProvider for the related ValorCaracteristicaModeloComponenteHardware array
        $query = ValorCaracteristicaModeloComponenteHardware::find()
                    ->andFilterWhere(['modelo_componente_hardware_id' => $id]);
        $caracteristicasDataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $model = $this->findModel($id);
        
        return $this->renderAjax('view-caracteristicas', [
            'dataProvider' => $caracteristicasDataProvider,
        	'model' => $model
        ]);
    }

    /**
     * Creates a new ModeloComponenteHardware model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ModeloComponenteHardware();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            DynamicRelations::relate($model, 'valoresCaracteristicasModeloComponenteHardware', Yii::$app->request->post(), 'ValorCaracteristicaModeloComponenteHardware', ValorCaracteristicaModeloComponenteHardware::className());          
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ModeloComponenteHardware model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // Backup inventario property to avoid being overriden as SwitchInput widget does not send the value
        // when it's in disabled mode
		$inventario = $model->inventario;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	$model->inventario = $inventario;
        	$model->save();
            DynamicRelations::relate($model, 'valoresCaracteristicasModeloComponenteHardware', Yii::$app->request->post(), 'ValorCaracteristicaModeloComponenteHardware', ValorCaracteristicaModeloComponenteHardware::className());
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ModeloComponenteHardware model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$model = $this->findModel($id);
    	try {
            $model->delete();
            Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
            		'modelClass' => $model->singularObjectName()
            ]));
        } catch (yii\db\IntegrityException $e) {
            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in some {modelClass2}', [
                'modelClass' => $model->singularObjectName(),
                'modelClass2' => \app\models\ComponenteHardware::singularObjectName()
                ]));
            }
        } 
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the ModeloComponenteHardware model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ModeloComponenteHardware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ModeloComponenteHardware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionInventario()
    {
        $id = Yii::$app->request->post('id');
        if ($id !== null){
            echo Json::encode(ModeloComponenteHardware::findOne($id)->inventario != null);
            return;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }
    
    public function actionModelosByCategoria($inventario) {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];            
            if ($parents != null) {
                $categoria_id = $parents[0];
                $out = ModeloComponenteHardware::getModelosByCategoria($categoria_id,$inventario); 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionMarcas($q = null) {
        $query = new yii\db\Query;
        
        $query->select('marca')
            ->from('modelo_componente_hardware')
            ->where('marca LIKE "%' . $q .'%"')
            ->orderBy('marca');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['marca']];
        }
        echo Json::encode($out);
    }
    
     public function actionModelos($q = null) {
        $query = new yii\db\Query;
        
        $query->select('modelo')
            ->from('modelo_componente_hardware')
            ->where('modelo LIKE "%' . $q .'%"')
            ->orderBy('modelo');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['modelo']];
        }
        echo Json::encode($out);
    }
}
