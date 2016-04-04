<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Caracteristica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="caracteristica-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidades')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_activo')->dropDownList([ Yii::t('app','Infrastructure') => 'Infraestructura', Yii::t('app','Software') => 'Software', Yii::t('app','Hardware') => 'Hardware', ], ['prompt' => Yii::t('app','- Select the asset type -') ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>        
    </div>

    <?php ActiveForm::end(); ?>

</div>
