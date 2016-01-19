<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activo-software-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'ActivoInventariableID')->textInput(['maxlength' => true]) ?>-->
    
    <?= $form->field($model, 'Codigo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'FechaCompra')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'es',
        'dateFormat' => 'dd/MM/yyyy',
        ]) ?>
    <?= $form->field($model, 'PrecioCompra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SubcategoriaID')->dropDownList($model->getSubcategorias(),['prompt'=>'- Selecciona la categoría del activo software -']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
