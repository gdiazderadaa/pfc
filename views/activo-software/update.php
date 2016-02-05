<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

 $this->title = Yii::t('app', 'Update {modelClass}:', [
		              'modelClass' => 'Software Asset',
		              ]) . ' ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->activo_inventariable_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="activo-software-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
