<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ElementoHardware */

 $this->title = Yii::t('app', 'Update {modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->marca . ' ' . $model->modelo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->marca . ' ' . $model->modelo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="elemento-hardware-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
