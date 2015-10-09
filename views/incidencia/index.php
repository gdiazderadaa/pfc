<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Incidencia;
use app\models\Estado;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consola de incidencias';
$this->params['breadcrumbs'][] = $this->title;

$totalTickets = Incidencia::find()
    ->count();
    
$newTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Nueva')])
    ->count();

$assignedTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Asignada')])
    ->count();
    
$ongoingickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('En progreso')])
    ->count();
    
$pendingTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Pendiente')])
    ->count();
    
$resolvedTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Resuelta')])
    ->count();
    
$closedTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Cerrada')])
    ->count();
    
$cancelledTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Cancelada')])
    ->count();
?>
<div class="incidencia-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    

        <div class="row">
            <div class="col-md-4 pull-left">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="col-md-8  pull-right">
                <?= Highcharts::widget([
                'options' => [
                    'credits' => false,
                    'chart' => [ 
                        'type' => 'bar',
                        'height' => 100,
                        'spacing' => 0
                    ],
                    'title' => [ 'style' => ['display'=>'none'] ],
                    'xAxis' => [
                        'lineWidth'=>0,
                        'gridLineWidth'=>0,
                        'labels' => [ 'style' => ['display'=>'none'] ],
                    ],
                    'yAxis' => [
                        'lineWidth'=>0,
                        'gridLineWidth'=>0,
                        'labels' => [ 'style' => ['display'=>'none'] ],
                        'min' => 0,
                        'title' => [ 'style' => ['display'=>'none'] ],
                        'stackLabels' => [
                            'enabled' => true,
                            'style' => [
                                'fontWeight' => 'bold',
                                'color' => new JsExpression("(Highcharts.theme && Highcharts.theme.textColor) || 'gray'")
                            ]
                        ]
                    ],
                    'legend' => [
                        'enabled' => false,
                    ],
                    'tooltip' => [
                        'headerFormat' => '',
                        'pointFormat' => '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                    ],
                    'plotOptions' => [
                        'series' => [
                            'stacking' => 'normal',
                            'dataLabels' => [
                                'enabled' => true,
                                'color' => new JsExpression("(Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'"),
                                'style' => [
                                    'textShadow' => '0 0 3px black'
                                ]
                            ]
                        ]
                    ],
                    'series' => [[
                        'name' => 'Nuevas',
                        'data' => [2],
                    ], [
                        'name' => 'Asignadas',
                        'data' => [4],
                    ], [
                        'name' => 'En proceso',
                        'data' => [7],
                    ], [
                        'name' => 'Pendientes',
                        'data' => [2],
                    ], [
                        'name' => 'Resueltas',
                        'data' => [15],
                    ], [
                        'name' => 'Cerradas',
                        'data' => [4],
                    ], [
                        'name' => 'Canceladas',
                        'data' => [6],
                    ]]
                ]
            ]); ?> 
    
            </div>
        </div>           

    
        
    
    <p>
        <?= Html::a('Crear Incidencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'urgencia_id',
                'value' => function ($model) {
                            return $model->urgencia->nombre;
                        }
            ],
            [
                'attribute' => 'id',
                'value' => function ($model) {
                            return $model->getIdWithLeadingZeros();
                        }
            ],
            [
                'attribute' => 'creador_id',
                'value' => function ($model) {
                            return $model->creador->email;
                        }
            ],
            'descripcion_breve',
            [
                 'attribute' => 'fecha_creacion',
                 'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->fecha_creacion,'dd/MM/yyyy HH:mm:ss');
                        }
             ],
            
            //'descripcion:ntext',
            [
                 'attribute' => 'tipo_id',
                 'value' => function ($model) {
                            return $model->tipo->nombre;
                        }
             ],
             [
                 'attribute' => 'impacto_id',
                 'value' => function ($model) {
                            return $model->impacto->nombre;
                        }
             ],


            // 'objeto_id',

            // 'fecha_fin',
             [
                 'attribute' => 'estado_id',
                 'value' => function ($model) {
                            return $model->estado->nombre;
                        }
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
