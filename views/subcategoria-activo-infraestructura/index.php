<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubcategoriaActivoInfraestructuraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Infrastructure Asset Subcategories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-activo-infraestructura-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
		                  'modelClass' => 'Infrastructure Asset Subcategory']), 
                    ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
