<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComponenteHardwareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="componente-hardware-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'numero_serie') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'modelo_componente_hardware_id') ?>

    <?= $form->field($model, 'fecha_compra') ?>

    <?php // echo $form->field($model, 'precio_compra') ?>

    <?php // echo $form->field($model, 'activo_hardware_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
