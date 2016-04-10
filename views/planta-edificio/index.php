<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlantaEdificioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $searchModel->pluralObjectName());
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planta-edificio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Planta Edificio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',
            [
                'attribute' => 'imagen',
                'format' => 'html',
                'value' => function($data) {
                    return Html::img( $data->imageUrl, [
                        'width' => '200px',
                        'alt' => $data->nombre,
                        'title' => $data->nombre,
                    ]); }
            ],
            [
                 'attribute' => 'edificio_id',
                 'value' => 'edificio.nombre'
            ], 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
