<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use app\models\Categoria;
use app\models\ModeloComponenteHardware;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoHardwareComponenteHardware */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="attach-child-componente-hardware-form">

    <?php $form = ActiveForm::begin([
            'id' => 'attach-child-form',
            'options' => ['role' => 'form'],
            'enableAjaxValidation' => true,
            'enableClientScript' => true,
            //'enableClientValidation' => true,
        ]); ?>	

    <?= Html::csrfMetaTags() ?>
    
    <div class="form-group">
        <label class="control-label"><?=Categoria::singularObjectName()?></label>
        <?= Select2::widget([
        	'theme' => Select2::THEME_DEFAULT,
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
        	'select2Options' => ['theme' => Select2::THEME_DEFAULT],
            'name' => 'modelo',
            'options' =>[
                'id'=>'modelo-id',
                'placeholder'=> Yii::t('app', 'Select a model'),
            ],
            'pluginOptions'=>[
                    'depends'=>['categoria-id'],              
                    'url'=>Url::to(['/modelo-componente-hardware/modelos-by-categoria', 'inventario'=> -1])
                ]
        ]); ?>
    </div> 

    <?= $form->field($model, 'activo_hardware_id')->hiddenInput()->label(false); ?>

    <?= $form->field($model, 'componente_hardware_id')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
    		'select2Options' => ['theme' => Select2::THEME_DEFAULT],
            'options' =>[
                'placeholder'=> Yii::t('app', 'Select a component'),
            ],
            'pluginOptions'=>[
                    'depends'=>['modelo-id'],       
                    'url'=>Url::to(['/componente-hardware/componentes-by-modelo'])
                ]
        ]); ?>


    
    <?php ActiveForm::end(); ?>
</div>
