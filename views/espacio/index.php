<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspacioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Spaces');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espacio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
		                  'modelClass' => 'Space']), 
                    ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nombre',
            'numeracion',
             [
                 'attribute' => 'edificio_id',
                 'value' => 'edificio.nombre'
             ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
