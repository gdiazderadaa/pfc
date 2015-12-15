<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoInfraestructuraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activos Infraestructura';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Activo Infraestructura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Codigo',
            'Nombre',
            [
                 'attribute' => 'SubcategoriaID',
                 'value' => function ($model) {
                            return $model->subcategoria->Nombre;
                        }
            ],
            [
                'attribute' => 'FechaCompra',
                'format'    => ['date', 'dd/MM/yy']
            ],
            [
                'attribute' => 'PrecioCompra',
                'format'    => ['currency', 'EUR']
            ],    
                 
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
