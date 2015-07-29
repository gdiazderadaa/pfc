<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IncidenciaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incidencia-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion_breve') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'tipo_id') ?>

    <?= $form->field($model, 'impacto_id') ?>

    <?php // echo $form->field($model, 'urgencia_id') ?>

    <?php // echo $form->field($model, 'tecnico_id') ?>

    <?php // echo $form->field($model, 'objeto_id') ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'fecha_fin') ?>

    <?php // echo $form->field($model, 'estado_id') ?>

    <?php // echo $form->field($model, 'creador_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
