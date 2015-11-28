<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CaracteristicaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Caracteristicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caracteristica-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Caracteristica', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CaracteristicaID',
            'Nombre',
            'Unidades',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
