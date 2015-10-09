<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjetoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de activos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objeto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear activo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'codigo',
            'nombre',
            [
                 'attribute' => 'fecha_compra',
                 'value' => function ($model) {
                            return Yii::$app->formatter->asDate($model->fecha_compra,'dd/MM/yyyy');
                        }
            ],
            [
                 'attribute' => 'espacio_id',
                 'value' => function ($model) {
                            return $model->espacio->nombre;
                        }
            ],
            [
                 'attribute' => 'tipo_id',
                 'value' => function ($model) {
                            return $model->tipo->nombre;
                        }
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
