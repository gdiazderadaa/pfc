<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\models\ValorCaracteristicaActivo;
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activo-software-form">

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

    <?= $form->field($model, 'subcategoria_activo_software_id')->dropDownList($model->getSubcategorias(),['prompt'=>Yii::t('app', '- Select the {modelClass} -', [
		              'modelClass' => 'Sofware Asset Subcategory',
		              ]) ]) ?>
    
    <?= DynamicRelations::widget([
        'title' => Yii::t('app','Features'),
        'collection' => $model->valoresCaracteristicasActivoInventariable,
        'viewPath' => '@app/views/valor-caracteristica-activo-inventariable/_inline.php',

        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\ValorCaracteristicaActivoInventariable,

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
