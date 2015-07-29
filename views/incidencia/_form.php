<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Incidencia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="incidencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion_breve')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

	<?=$form->field($model, 'tipo_id')->dropDownList($model->getTipoList(),['prompt'=>'- Selecciona el tipo de incidencia -']) ?>

    <?= $form->field($model, 'impacto_id')->dropDownList($model->getImpactoList(),['prompt'=>'- Selecciona el impacto de la incidencia -']) ?>

    <?= $form->field($model, 'urgencia_id')->dropDownList($model->getUrgenciaList(),['prompt'=>'- Selecciona la urgencia de la incidencia -']) ?>

    <!--<?= $form->field($model, 'tecnico_id')->textInput() ?>-->

    <?= $form->field($model, 'objeto_id')->textInput() ?>

    <!--<?= $form->field($model, 'fecha_creacion')->textInput() ?>-->

    <!--<?= $form->field($model, 'fecha_fin')->textInput() ?>-->

    <!--<?= $form->field($model, 'estado_id')->textInput() ?>-->

    <!--<?= $form->field($model, 'creador_id')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
