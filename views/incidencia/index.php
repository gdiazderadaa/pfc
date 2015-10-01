<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Incidencia;
use app\models\Estado;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Incidencias';
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
    
$closedTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Cerrada')])
    ->count();
    
$cancelledTickets = Incidencia::find()
    ->where(['estado_id' => Estado::findOne('Cancelada')])
    ->count();
?>
<div class="incidencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <h2>Total tickets: <?= Html::encode($totalTickets) ?></h2>
    <h3>Nuevos: <?= Html::encode($totalNew) ?></h3>
    <h3></h3>
    <h3></h3>
    <h3></h3>
    <h3></h3>
    <h3></h3>
    <h3></h3>
    <h3></h3>

    <p>
        <?= Html::a('Crear Incidencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descripcion_breve',
            //'descripcion:ntext',
            'tipo_id',
            'impacto_id',
             'urgencia_id',
             'tecnico_id',
            // 'objeto_id',
             'fecha_creacion',
            // 'fecha_fin',
             'estado_id',
            // 'creador_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
