<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\models\ValorCaracteristicaActivo;
use synatree\dynamicrelations\DynamicRelations;

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
    
    <?= DynamicRelations::widget([
        'title' => 'Caracteristicas',
        'collection' => $model->valorCaracteristicaActivos,
        'viewPath' => '@app/views/valor-caracteristica-activo/_inline.php',

        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\ValorCaracteristicaActivo,

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
