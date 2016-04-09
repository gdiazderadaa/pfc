<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\Helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\PlantaEdificio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planta-edificio-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php 
        if($model->isNewRecord || !isset($model->imagen) || !isset($model->imagen_servidor)){
            echo $form->field($model, 'imagen')->widget(FileInput::classname(),[
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>[
                    'allowedFileExtensions'=>['jpg','gif','png'],
                    'showRemove' => true,
                    'showUpload' => false,
                ]
            ]);  
        }else{
           echo $form->field($model, 'imagen')->widget(FileInput::classname(),[
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>[
                    'allowedFileExtensions'=>['jpg','gif','png'],
                    'showRemove' => true,
                    'showUpload' => false,
                    'initialPreview'=>[
                        Html::img($model->getImageUrl(), ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                    ],
                    'initialCaption'=> isset($model->nombre) ? $model->nombre : '',
                ]
            ]);  
        }
        ?>

    <?= $form->field($model, 'edificio_id')->dropDownList($model->getEdificioList(),['prompt'=>Yii::t('app', '- Select the {modelClass} where the {modelClass2} is located -', [
		              'modelClass' => $model->attributeLabels()['edificio_id'],
                      'modelClass2' => $model->singularObjectName(),
		              ]) ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
