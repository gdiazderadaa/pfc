<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Caracteristica */

$this->title = 'Update Caracteristica: ' . ' ' . $model->CaracteristicaID;
$this->params['breadcrumbs'][] = ['label' => 'Caracteristicas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CaracteristicaID, 'url' => ['view', 'id' => $model->CaracteristicaID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="caracteristica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
