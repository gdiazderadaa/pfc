<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ValorCaracteristicaActivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Valor Caracteristica Activos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Valor Caracteristica Activo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                 'attribute' => 'ActivoInventariableID',
                 'value' => function ($model) {
                            return $model->activoInventariable->Nombre;
                        }
            ],

            [
                 'attribute' => 'Subcategoria',
                 'value' => function ($model) {
                            return $model->caracteristica->Nombre;
                        }
            ],
            
            'Valor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
