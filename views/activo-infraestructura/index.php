<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoInfraestructuraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activo Infraestructuras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Activo Infraestructura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'SubcategoriaID',
            'Codigo',
            'FechaCompra',
            'PrecioCompra',   
            'Nombre',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
