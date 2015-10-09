<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */

$this->title = 'Espacio: '. $model->edificio->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Espacios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espacio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Html::encode('¿Estás seguro de que deseas eliminar el espacio '. $model->edificio->nombre),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nombre',
            'numeracion',
            [
                'label' => 'Edificio',
                'value'=> $model->edificio->nombre,
            ],
        ],
    ]) ?>

</div>
