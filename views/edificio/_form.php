<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\Helpers\Url;
use synatree\dynamicrelations\DynamicRelations;
use PetraBarus\Yii2\GooglePlacesAutoComplete\GooglePlacesAutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Edificio */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('$(document).ready(function(){
                       $("#edificio-localidad").addClass("form-control");
                                          
                });
                    ', \yii\web\VIEW::POS_END);
                    
?>

<div class="edificio-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <!--<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'nombre')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'localidad')->textarea(['rows' => 6]) ?>-->
    
    <?= $form->field($model, 'localidad')->widget(GooglePlacesAutoComplete::className()) ?>
    
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
                ],
                'pluginEvents' => [
                    'fileclear' => 'function() { 
                                        console.log("File clear");
                                        $("#'.$model->id.'").val("");
                                    }',
                ]
            ]);  
        }
        ?>
    <input type="hidden" id="<?php echo $model->id ?>" name="Edificio[imagen]" value="<?php echo $model->imagen ?>" />
    
     <?= DynamicRelations::widget([
        'title' => Yii::t('app','Floors'),
        'collection' => $model->plantasEdificio,
        'viewPath' => '@app/views/planta-edificio/_inline.php',       

        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
        'collectionType' => new app\models\PlantaEdificio,

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
