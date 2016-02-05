<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoInfraestructuraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Infrastructure Assets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
		                  'modelClass' => 'Infrastructure Asset']), 
                    ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'codigo',
            'nombre',
            [
                 'attribute' => 'subcategoria_activo_infraestructura_id',
                 'value' => 'subcategoriaActivoInfraestructura.nombre'
            ],
            [
                'attribute' => 'fecha_compra',
                'format'    => ['date', 'dd/MM/yy']
            ],
            [
                'attribute' => 'precio_compra',
                'format'    => ['currency', 'EUR']
            ],
            [
                 'attribute' => 'espacio_id',
                 'value' => 'espacio.nombre'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
