<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use synatree\dynamicrelations\DynamicRelations;
use yii\helpers\Html;

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

<div class="alert alert-info alert-dismissible <?= !$model->isNewRecord ? 'hidden' : ''; ?>" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p><i class="icon fa fa-info"></i><?= Yii::t('app','Enter the details and {modelClass} of the {modelClass2} and click "Create"', [
                                'modelClass' => \app\models\PlantaEdificio::pluralObjectName(),
    							'modelClass2' => $model->singularObjectName(),
                                ]) ?>
</div>

<?php $form = ActiveForm::begin([
    	'id' => 'edificio-form',
        'options' => ['enctype'=>'multipart/form-data']
]); ?>
<div class="row">

    <div class="col-md-6">
		<div class="edificio-form box box-epi-green">

            <div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">


    
			    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
			    
			    <label class="control-label"><?php echo Yii::t('app','Location') ?></label>
			    
			    <div id="address" class="file-preview">
			        <label class="control-label"><?php echo Yii::t('app','Use Google Places to locate the place') ?></label>
			        
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
            </div>
               
            <div class="box-footer">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-epi-green btn-flat']) ?>
                    <?= Html::a(Yii::t('app', 'Cancel'),Yii::$app->request->referrer , ['class' => 'btn btn-default btn-flat']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">		    
	     <?= DynamicRelations::widget([
     		'boxClass' => 'epi-blue',
     		'header' => 'h3',
	        'title' => Yii::t('app','Floors'),
	        'collection' => $model->plantasEdificio,
	        'viewPath' => '@app/views/planta-edificio/_inline.php',       
	
	        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
	        'collectionType' => new app\models\PlantaEdificio,
	
	    ]); ?>   
    </div>
       
</div>
<?php ActiveForm::end(); ?>