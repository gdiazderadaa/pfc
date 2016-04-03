<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoSoftwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $searchModel->pluralObjectName());
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-software-index">

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

            'codigo',
            'nombre',
            [
                 'attribute' => 'subcategoria_activo_software_id',
                 'value' => 'subcategoriaActivoSoftware.nombre'
            ],
            [
                'attribute' => 'fecha_compra',
                'format'    => 'date'
            ],
            [
                'attribute' => 'precio_compra',
                'format'    => 'currency'
            ],   

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
