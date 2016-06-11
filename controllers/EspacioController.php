<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use app\models\Espacio;
use app\models\EspacioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * EspacioController implements the CRUD actions for Espacio model.
 */
class EspacioController extends Controller
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
     * Lists all Espacio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EspacioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Espacio model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model = $this->findModel($id);
    	
    	// Set dataProvider for the related ActivoInfraestructura array
    	$activosInfraestructura = new ActiveDataProvider([
    			'query' => $model->getActivosInfraestructura(),
    	]);
    	
    	// Set dataProvider for the related ActivoHardware array
    	$activosHardware = new ActiveDataProvider([
    			'query' => $model->getActivosHardware(),
    	]);
    	
        return $this->render('view', [
            'model' => $this->findModel($id),
        	'activosInfraestructura' => $activosInfraestructura,
        	'activosHardware' => $activosHardware
        ]);
    }

    /**
     * Creates a new Espacio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Espacio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Espacio model.
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
     * Deletes an existing Espacio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success',Yii::t('app', 'The {modelClass} has been successfully deleted', [
            		'modelClass' => 'space',
            ]));
        } catch (yii\db\IntegrityException $e) {
            if($e->getCode() == 23000){
                Yii::$app->session->setFlash('danger',Yii::t('app', 'Unable to delete the {modelClass} since it is being used in some {modelClass2}', [
                'modelClass' => 'space',
                'modelClass2' => 'asset',
                ]));
            }
        }

        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Espacio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Espacio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Espacio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionEspaciosByPlantaEdificio() 
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $planta_edificio_id = $parents[0];
                $out = Espacio::getEspaciosByPlantaEdificioId($planta_edificio_id); 
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
    
    public function actionNombres($q = null) {
    	$query = new yii\db\Query;
    
    	$query->select('nombre')
    	->from('espacio')
    	->where('nombre LIKE "%' . $q .'%"')
    	->orderBy('nombre');
    	$command = $query->createCommand();
    	$data = $command->queryAll();
    	$out = [];
    	foreach ($data as $d) {
    		$out[] = ['value' => $d['nombre']];
    	}
    	echo Json::encode($out);
    }
    
    public function actionNumeraciones($q = null) {
    	$query = new yii\db\Query;
    
    	$query->select('numeracion')
    	->from('espacio')
    	->where('numeracion LIKE "%' . $q .'%"')
    	->orderBy('numeracion');
    	$command = $query->createCommand();
    	$data = $command->queryAll();
    	$out = [];
    	foreach ($data as $d) {
    		$out[] = ['value' => $d['numeracion']];
    	}
    	echo Json::encode($out);
    }
}
