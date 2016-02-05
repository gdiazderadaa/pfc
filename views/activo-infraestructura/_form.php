<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activo-infraestructura-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'activo_inventariable_id')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fecha_compra')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]
    ]); ?>
    <?= $form->field($model, 'precio_compra')->widget(MaskMoney::classname()) ?>

    <?= $form->field($model, 'subcategoria_activo_infraestructura_id')->dropDownList($model->getSubcategorias(),['prompt'=>Yii::t('app', '- Select the {modelClass} -', [
		              'modelClass' => 'Infrastructure Asset Subcategory',
		              ]) ]) ?>

    <?= $form->field($model, 'espacio_id')->dropDownList($model->getEspacios(),['prompt'=>Yii::t('app', '- Select the {modelClass} where the {modelClass2} is located -', [
		              'modelClass' => 'Space',
                      'modelClass2' => 'Infrastructure Asset',
		              ]) ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
