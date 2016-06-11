<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ParteElementoHardware */

 $this->title = Yii::t('app', 'Update {modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->parteElementoHardware->marca . ' ' . $model->parteElementoHardware->modelo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parteElementoHardware->marca . ' ' . $model->parteElementoHardware->modelo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="parte-elemento-hardware-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
