<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = 'Update Activo Infraestructura: ' . ' ' . $model->Codigo;
$this->params['breadcrumbs'][] = ['label' => 'Activos Infraestructura', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Codigo, 'url' => ['view', 'id' => $model->ActivoInventariableID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activo-infraestructura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
