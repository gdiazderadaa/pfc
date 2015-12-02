<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivo */

$this->title = 'Update Valor Caracteristica Activo: ' . ' ' . $model->CaracteristicaID;
$this->params['breadcrumbs'][] = ['label' => 'Valor Caracteristica Activos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CaracteristicaID, 'url' => ['view', 'CaracteristicaID' => $model->CaracteristicaID, 'ActivoInventariableID' => $model->ActivoInventariableID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="valor-caracteristica-activo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
