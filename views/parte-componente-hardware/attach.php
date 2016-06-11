<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use app\models\Categoria;
use app\models\ModeloComponenteHardware;

/* @var $this yii\web\View */
/* @var $model app\models\ParteComponenteHardware */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="attach-componente-hardware-form">

    <?php $form = ActiveForm::begin([
            'id' => 'attach-form',
            'options' => ['role' => 'form'],
            'enableAjaxValidation' => true,
            'enableClientScript' => true,
            'enableClientValidation' => true,
        ]); ?>	

    <?= Html::csrfMetaTags() ?>
    
    <div class="form-group">
        <label class="control-label"><?=Categoria::singularObjectName()?></label>
        <?= Select2::widget([
            'name' => 'categoria',
            'data' => Categoria::getCategorias(),
            'options' => [
                    'id'=>'categoria-id',
                    'placeholder' => Yii::t('app', 'Select a category')
                ]
        ]); ?>
    </div> 

    <div class="form-group">
        <label class="control-label"><?=ModeloComponenteHardware::singularObjectName()?></label>
        <?= DepDrop::widget([
            'type' => DepDrop::TYPE_SELECT2,
            'name' => 'modelo',
            'options' =>[
                'id'=>'modelo-id',
                'placeholder'=> Yii::t('app', 'Select a model'),
            ],
            'pluginOptions'=>[
                    'depends'=>['categoria-id'],              
                    'url'=>Url::to(['/modelo-componente-hardware/modelos-by-categoria'])
                ]
        ]); ?>
    </div> 

    <?= $form->field($model, 'componente_hardware_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'parte_componente_hardware_id')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' =>[
                'placeholder'=> Yii::t('app', 'Select a part'),
            ],
            'pluginOptions'=>[
                    'depends'=>['modelo-id'],       
                    'url'=>Url::to(['/componente-hardware/componentes-by-modelo'])
                ]
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Attach') , ['class' =>  'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>

