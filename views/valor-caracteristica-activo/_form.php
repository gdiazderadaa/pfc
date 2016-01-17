<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="valor-caracteristica-activo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CaracteristicaID')->dropDownList($model->getCaracteristicas(),['prompt'=>'- Selecciona la característica -']) ?>

    <?= $form->field($model, 'ActivoInventariableID')->dropDownList($model->getActivosInventariables(),['prompt'=>'- Selecciona lel activo -']) ?>

    <?= $form->field($model, 'Valor')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>