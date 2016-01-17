<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoInfraestructura */

$this->title = $model->SubcategoriaActivoInfraestructuraID;
$this->params['breadcrumbs'][] = ['label' => 'Subcategoria Activo Infraestructuras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-activo-infraestructura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SubcategoriaActivoInfraestructuraID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SubcategoriaActivoInfraestructuraID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['label' => 'Subcategoria','value'=> $model->Subcategoria->Nombre],
            ['label' => 'Subcategoria','value'=> $model->ActivoInventariable->Nombre],
            //'SubcategoriaActivoInfraestructuraID',
            //'Nombre',
        ],
    ]) ?>

</div>
