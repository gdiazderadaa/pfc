<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activo-infraestructura-form">

    <?php $form = ActiveForm::begin([
                'options' => [
                    'id' => 'create-activo-infraestructura-form'
                ]
    ]); ?>

    <!--<?= $form->field($model, 'ActivoInventariableID')->textInput(['maxlength' => true]) ?>-->
    
    <?= $form->field($model, 'Codigo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'FechaCompra')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'es',
        'dateFormat' => 'dd/MM/yyyy',
        ]) ?>
    <?= $form->field($model, 'PrecioCompra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SubcategoriaID')->dropDownList($model->getSubcategorias(),['prompt'=>'- Selecciona la categoría del activo infraestructura -']) ?>
    
    <?= Html::button(
        'Nueva categoria', 
        [
            'value' => Url::to(['subcategoria-activo-infraestructura/create']), 
            'title' => 'Crear nueva categoria', 
            'class' => 'showModalButton btn btn-success'
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
