<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParteElementoHardware */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parte-elemento-hardware-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'elemento_hardware_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parte_elemento_hardware_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>