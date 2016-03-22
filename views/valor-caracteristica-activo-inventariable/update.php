<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivoInventariable */

$this->title = Yii::t('app', 'Update {modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->caracteristica->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caracteristica->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="valor-caracteristica-activo-inventariable-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
