<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloComponenteHardwareSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modelo-componente-hardware-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'marca') ?>

    <?= $form->field($model, 'modelo') ?>

    <?= $form->field($model, 'categoria_id') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?php // echo $form->field($model, 'inventario') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
