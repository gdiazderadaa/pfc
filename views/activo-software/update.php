<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = 'Update Activo Software: ' . ' ' . $model->ActivoInventariableID;
$this->params['breadcrumbs'][] = ['label' => 'Activo Softwares', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ActivoInventariableID, 'url' => ['view', 'id' => $model->ActivoInventariableID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activo-software-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
