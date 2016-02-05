<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="espacio-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeracion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edificio_id')->dropDownList($model->getEdificioList(),['prompt'=>Yii::t('app', '- Select the {modelClass} -', [
		              'modelClass' => 'Building',
		              ]) ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
