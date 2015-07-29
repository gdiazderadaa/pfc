<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IncidenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Incidencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incidencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
