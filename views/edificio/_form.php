<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\Helpers\Url;
use synatree\dynamicrelations\DynamicRelations;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Edificio */
/* @var $form yii\widgets\ActiveForm */

use app\assets\MapAsset;
MapAsset::register($this);

$this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false&libraries=places');
$this->registerJs('$(document).ready(function(){
                        // Default to EPI
                        latitude = 43.5243283;
                        longitude = -5.6346751;
                        
                        var geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ "address": "'.$model->localidad.'" }, function (results, status) {
                            
                            if (status == google.maps.GeocoderStatus.OK) {
                                document.getElementsByName("use-gmaps")[0].checked = true;
                                $("#edificio-localidad").attr("readonly",true);
                                latitude = results[0].geometry.location.lat();
                                longitude = results[0].geometry.location.lng();
                            }
                            else{
                                document.getElementsByName("use-gmaps")[0].checked = false;
                                $("#edificio-localidad").attr("readonly",false);
                            }
                            
                            $("#mapa").locationpicker({
                                location: {latitude: latitude, longitude: longitude},
                                radius: 0,
                                inputBinding: {
                                    locationNameInput: $("#search")        
                                },
                                enableAutocomplete: true,
                                oninitialized: function(component) {
                                    //$("#search").val("'.$model->localidad.'");                         
                                },
                                onchanged: function(currentLocation, radius, isMarkerDropped) {
                                    var location = $(this).locationpicker("map").location;
                                    updateControls(location);
                                }	
                            });
                        });
                        
                        function updateControls(location) {
                            $("#edificio-localidad").val(location.formattedAddress);    
                        }

                        
                });
                
                    ', \yii\web\VIEW::POS_READY);
                    
?>

<div class="edificio-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <!--<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <label class="control-label"><?php echo Yii::t('app','Location') ?></label>
    
    <div id="address" class="file-preview">
        <label class="control-label"><?php echo Yii::t('app','Use Google maps to locate the place') ?></label>
        
        <?= SwitchInput::widget(['name'=>'use-gmaps', 
            'value'=>true,
            'pluginOptions' => [
                'onText' => Yii::t('app','Yes'),
                'offText' => Yii::t('app','No'),
            ],
            'pluginEvents' => [
            'switchChange.bootstrapSwitch' => 'function() { 
                console.log(this.checked);
                if (this.checked == false){
                    $("#gmaps-panel").hide("slow");
                    $("#edificio-localidad").attr("readonly", false);
                    }
                    else {
                        $("#gmaps-panel").show("slow");
                        $("#edificio-localidad").attr("readonly", true);
                    }
                }'
            ]
        ]); ?>
    
    <div class="form-group" id="gmaps-panel">
        <label class="control-label" for="search"><?php echo Yii::t('app','Place lookup') ?></label>
        <input id="search" class="form-control" placeholder="<?php echo Yii::t('app','Type in the name or address of a building') ?>"/>
            <div id="mapa" class="form-control" style="height:350px; margin-top:15px"></div>
        </div>
            
        <?= $form->field($model, 'localidad')->textInput(['maxlength' => true]) ?>
    </div>
  

      
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
