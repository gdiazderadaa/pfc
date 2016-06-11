<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ElementoHardware */

$this->title = $model->marca . ' ' . $model->modelo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update') . ' ' . $model->marca . ' ' . $model->modelo;
?>
<div class="elemento-hardware-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
