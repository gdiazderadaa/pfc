<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Incidencia */

/*Calculate leading zeros depending on the lenght of id content*/
$this->title = 'Incidencia '. $model->getIdWithLeadingZeros();
$this->params['breadcrumbs'][] = ['label' => 'Incidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incidencia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            /*'id',*/
            'descripcion_breve',
            'descripcion:ntext',
            [
                'label' => 'Categoria',
                'value'=> $model->tipo->nombre,
            ],
            [
                'label' => 'Impacto',
                'value'=> $model->impacto->nombre,
            ],
            [
                'label' => 'Urgencia',
                'value'=> $model->urgencia->nombre,
            ],
            [
                'label' => 'Tecnico',
                'value'=> $model->tecnico->username,
            ],
            [
                'label' => 'Objeto',
                'value'=> $model->objeto->nombre,
            ],
            'fecha_creacion',
            'fecha_fin',
            [
                'label' => 'Estado',
                'value'=> $model->estado->nombre,
            ],
            [
                'label' => 'Creador',
                'value'=> $model->creador->email,
            ],
        ],
    ]) ?>

</div>
