<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\models\ParteElementoHardware;
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ElementoHardware */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="elemento-hardware-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'numero_serie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subcategoria_elemento_hardware_id')->dropDownList($model->getSubcategoriaElementoHardwareList(),['prompt'=>Yii::t('app', '- Select the {modelClass} -', [
		              'modelClass' => $model->attributeLabels()['subcategoria_elemento_hardware_id'],
		              ]) ]) ?>

    <?= $form->field($model, 'fecha_compra')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'precio_compra', [
                    'addon' => ['append' => ['content'=>Yii::$app->formatter->numberFormatterSymbols[Yii::$app->formatter->currencyCode]]],
                    ]); ?>

    <?= $form->field($model, 'activo_hardware_id')->dropDownList($model->getActivoHardwareList(),['prompt'=>Yii::t('app', '- Select the {modelClass} -', [
		              'modelClass' => $model->attributeLabels()['activo_hardware_id'],
		              ]) ]) ?>
                      
    <?= DynamicRelations::widget([
        'title' => Yii::t('app','Features'),
        'collection' => $model->valoresCaracteristicasElementoHardware,
        'viewPath' => '@app/views/valor-caracteristica-elemento-hardware/_inline.php',
        'params' => ['tipo_activo' => 'Hardware'],
        
        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\ValorCaracteristicaElementoHardware,

    ]); ?>               
                      
    <?= DynamicRelations::widget([
        'title' => Yii::t('app','Parts'),
        'collection' => $model->partesElementoHardware,
        'viewPath' => '@app/views/parte-elemento-hardware/_inline.php',
        'params' => ['parent_id' => $model->id],
        
        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\ParteElementoHardware,

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
