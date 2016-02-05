<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */

$this->title = Yii::t('app', 'Update {modelClass}:', [
		   'modelClass' => 'space',
		]) . ' ' . $model->numeracion;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spaces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-> numeracion, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="espacio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
