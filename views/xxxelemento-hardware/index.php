<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ElementoHardwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $searchModel->pluralObjectName());
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elemento-hardware-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
		                  'modelClass' => $searchModel->singularObjectName()]),
                    ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'numero_serie',
            'marca',
            'modelo',
            [
                'attribute' => 'subcategoria_elemento_hardware_id',
                'value' => 'subcategoriaElementoHardware.nombre'
            ],
            [
                'attribute' => 'fecha_compra',
                'format'    => 'date'
            ],
            [
                'attribute' => 'precio_compra',
                'format'    => 'currency'
            ],
            [
                 'attribute' => 'activo_hardware_id',
                 'value' => 'activoHardware.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
