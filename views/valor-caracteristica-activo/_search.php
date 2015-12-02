<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="valor-caracteristica-activo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'CaracteristicaID') ?>

    <?= $form->field($model, 'ActivoInventariableID') ?>

    <?= $form->field($model, 'Valor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
