<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use app\models\ActivoInventariable;
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use kartik\widgets\DatePicker;


?>

<div class="activo-hardware-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'activo_inventariable_id')->textInput(['maxlength' => true]) ?>-->
    
    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'fecha_compra')->widget(DateControl::classname(), [
        'type'=>DateControl::FORMAT_DATE,
        'ajaxConversion'=>false,
        'options' => [
            'pluginOptions' => [
                'autoclose' => true,
                'endDate' => '+0d'
            ]
        ]
    ]); ?>
    
    <?php
        if ($model->isNewRecord)
        {
    ?>
            <div class="form-group">
            <label class="control-label" for="garantia"><?= Yii::t('app','Warranty') ?></label>
            <div class="form-group row">
                <div class="col-md-1">       
                    <?php echo MaskedInput::widget([
                            'name' => 'garantia',
                            'clientOptions' => [
                                'alias' =>  'integer',
                                'autoGroup' => false
                            ],        
                        ]); ?>
                </div>
                
                <div class="col-md-2">  
                    <?php echo Select2::widget([
                            'name' => 'unidad-garantia',
                            'hideSearch' => true,
                            'data' => $model->getTiposGarantia(),
                            'value' => ActivoInventariable::YEARS

                        ]); ?>
                    </div>
                </div>
            </div>
    <?php
        }
        else 
        {

    ?>
    
            <?= $form->field($model, 'fecha_fin_garantia')->widget(DateControl::classname(), [
                'type'=>DateControl::FORMAT_DATE,
                'disabled'=>true,
                'ajaxConversion'=>false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'endDate' => '+0d'
                    ]
                ]
            ]); ?>
    
    <?php
            if ($model->enGarantia()) {
                echo '<p class="text-success small">'. Yii::t('app','Under Warranty').'</p>';
            }
            else {
                echo '<p class="text-danger small">'. Yii::t('app','Expired Warranty').'</p>';
            }
        }
    ?>
    

    
    <?= $form->field($model, 'precio_compra', [
            'addon' => ['append' => ['content'=> Yii::$app->formatter->numberFormatterSymbols[NumberFormatter::CURRENCY_SYMBOL]]],
            ])->widget('yii\widgets\MaskedInput', [
            'clientOptions' => [
                'alias' =>  'decimal',
                'groupSeparator' => Yii::$app->formatter->thousandSeparator,
                'radixPoint' => Yii::$app->formatter->decimalSeparator,
                'autoGroup' => true
            ], 
    ]); ?>
    
    <?= $form->field($model, 'subcategoria_activo_hardware_id')->widget(Select2::classname(), [     
        'data' => $model->getSubcategorias(),
        'options' => ['placeholder' => Yii::t('app', '- Select the {modelClass} -', [
                                        'modelClass' => $model->attributeLabels()['subcategoria_activo_hardware_id']
                                        ])],
    ]); ?>
    
    <?= $form->field($model, 'estado')->widget(Select2::classname(), [     
        'data' => $model->getEstados(),
        'options' => ['placeholder' => Yii::t('app', '- Select the status -')],
    ]); ?>
                      
    <?= $form->field($model, 'espacio_id')->widget(Select2::classname(), [     
        'data' => $model->getEspacios(),
        'options' => ['placeholder' => Yii::t('app',  '- Select the {modelClass} where the {modelClass2} is located -', [
                                        'modelClass' => $model->attributeLabels()['espacio_id'],
                                        'modelClass2' => $model->singularObjectName(),
                                        ])],
    ]); ?>
       
    
    <?= DynamicRelations::widget([
        'title' => Yii::t('app','Configuration'),
        'collection' => $model->configuracionesActivoHardware,
        'viewPath' => '@app/views/configuracion-activo-hardware/_inline.php',
        'params' => ['tipo_activo' => 'Hardware'],

        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\ConfiguracionActivoHardware,

    ]); ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
