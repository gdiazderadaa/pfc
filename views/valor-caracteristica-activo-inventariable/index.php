<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ValorCaracteristicaActivoInventariableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Asset Feature Value');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-inventariable-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
		                  'modelClass' => 'Asset Feature Value']), 
                    ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'activo_inventariable_id',
            'caracteristica_id',
            'valor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
