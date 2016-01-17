<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivo */

$this->title = $model->CaracteristicaID;
$this->params['breadcrumbs'][] = ['label' => 'Valor Caracteristica Activos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'CaracteristicaID' => $model->CaracteristicaID, 'ActivoInventariableID' => $model->ActivoInventariableID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'CaracteristicaID' => $model->CaracteristicaID, 'ActivoInventariableID' => $model->ActivoInventariableID], [
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
            ['label' => 'Activo','value'=> $model->activoInventariable->Nombre],
            ['label' => 'Subcategoría','value'=> $model->caracteristica->Nombre],
            'Valor',
        ],
    ]) ?>

</div>
