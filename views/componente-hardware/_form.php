<?php

use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use synatree\dynamicrelations\DynamicRelations;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use app\assets\ValidationAsset;
ValidationAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\ComponenteHardware */
/* @var $form yii\widgets\ActiveForm */

$url = Url::to(['/componente-hardware/seriales']);

$js = <<<JS

$("#componentes").hide();

function addValidation(){
    console.log($("#seriales .box-body").children().length);
    $("#seriales .box-body").children().each(function (index, value){
        console.log("Added validation for serial " + index)
        $('#componente-hardware-form').yiiActiveForm("add", {
            "id":        "serial-" + index,
            "name":      "ComponenteHardware[serial-" + index + "]",
            "container": "#serial-" + index + "group",
            "input":     "#serial-" + index,
            "error":    "#serial-" + index + "group .help-block",
            "validate":  function (attribute, value, messages, deferred, \$form) {
                yii.validation.required(value, messages, {'message': 'Validation Message Here'});
            }
        });
    });
}


$('#componentehardware-cantidad').change(function() {
    console.log("change cantidad");
    $.ajax({
        url: '{$url}' ,
        type:"POST",
        data:{'number' : $("#componentehardware-cantidad").val()},
        dataType:"html",
    })
    .done(function(html) {
        $("#seriales").html(html);
        addValidation();
        $("#seriales").show("slow");
    })
});
JS;
 
$this->registerJs($js); 

?>

<div class="alert alert-info-white alert-dismissible <?= !$model->isNewRecord ? 'hidden' : ''; ?>" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
    <ul>
    	<li><?= Yii::t('app','Select the {modelClass} yo want to use.',['modelClass' => \app\models\ModeloComponenteHardware::singularObjectName()]) ?></li>
    	<li><?= Yii::t('app','Enter the {fecha_compra}, {meses_garantia} and {precio_compra}.',[
    			'fecha_compra' => $model->getAttributeLabel('fecha_compra'),
    			'meses_garantia' => $model->getAttributeLabel('meses_garantia'),
    			'precio_compra' => $model->getAttributeLabel('precio_compra'),
    	]) ?></li>
    	<li><?= Yii::t('app','If the selected {modelClass} has the {inventario} on, you need to provide the {cantidad} of {modelClass2} to be created, as well as the {numero_serie} for each one.',[
    			'modelClass' => \app\models\ModeloComponenteHardware::singularObjectName(),
    			'modelClass2' => \app\models\ComponenteHardware::pluralObjectName(),
    			'inventario' => $model->getAttributeLabel('inventario'),
    			'cantidad' => $model->getAttributeLabel('cantidad'),
    			'numero_serie' => $model->getAttributeLabel('numero_serie'),
    	]) ?></li>
    	<li><?= Yii::t('app','Click on the "Create" button to finsh') ?></li>
    </ul> 
</div>

<?php $form = ActiveForm::begin(['id' => 'componente-hardware-form']); ?>
<div class="row">
    <div class="col-md-6">
		<div class="componente-hardware-form box box-epi-green">

			<div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">
     
		        <?= $form->field($model, 'modelo_componente_hardware_id')->widget(Select2::classname(), [
	        		'theme' => Select2::THEME_DEFAULT,
		        	'data' => $model->modelosComponenteHardware,
		            'options' => [
		                'placeholder' => ''
		            ],
		            'disabled' => !$model->isNewRecord,
		            'pluginEvents' => [
		                'change' => 'function() { 
		                                $.ajax({
		                                    url:"'.Url::to(['/modelo-componente-hardware/inventario']).'",
		                                    type:"POST",            
		                                    data:{\'id\' : $(this).val()},
		                                    dataType:"json",
		                                    "success":function(data){ 
		                                        console.log("DATA: " + data);               
		                                        if(data===false){
		                                            console.log("false");
		                                            $(".field-componentehardware-cantidad").hide("slow");
		                                            $("#componentes").show("slow");
	                                                $("#seriales").hide("slow");  
		                                        }else{
		                                            console.log("true"); 
		                                            $(".field-componentehardware-cantidad").show("slow");
		                                            $("#componentes").hide("slow"); 
		                                            console.log($("#cantidad").val());
		                                            //if ($("#cantidad").val() != ""){
		                                                $("#seriales").show("slow");                                          
		                                            //}
		                                        }
		                                    }
		                                });
		                            }'
		            ]
		        ]) ?>
        
		        <?= $form->field($model, 'numero_serie',[
		            'options' => [
		                'style' => [
		                        'display' => !$model->isNewRecord && $model->modeloComponenteHardware != null && $model->modeloComponenteHardware->inventario ? 'inherit' : 'none'
		                ]
		            ]
		        ])->textInput(['maxlength' => true]) ?>
		        
		        <div class="row">
			        <div class="col-md-4">
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
			        </div>
			        
			        <div class="col-md-4">
				        <?= $form->field($model, 'meses_garantia',[
				            'addon'=>[
				                'append'=>[
				                    'content'=> Yii::t('app','Months') ,
				                ],
				            ]
				        ]); ?>
			        </div>
			        
			        <div class="col-md-4">
			        	<?= $form->field($model, 'precio_compra', [
	                            'addon' => ['append' => ['content'=> Yii::$app->formatter->numberFormatterSymbols[NumberFormatter::CURRENCY_SYMBOL]]],
	                            ])->widget('yii\widgets\MaskedInput', [
	                            'clientOptions' => [
	                                'alias' =>  'decimal',
	                                'groupSeparator' => Yii::$app->formatter->thousandSeparator,
	                                'radixPoint' => Yii::$app->formatter->decimalSeparator,
	                                'autoGroup' => false
	                            ], 
	                    ]); ?>
			        </div>
				</div>


		        
		        <?= ($model->isNewRecord) ? $form->field($model, 'cantidad')->widget(MaskedInput::className(),[
			            'clientOptions' => [
			                'alias' =>  'integer',
			            ],
			        ]) : '' ?>
		
		        <?= $form->field($model, 'estado')->widget(DepDrop::classname(), [
		            'type' => DepDrop::TYPE_SELECT2,
	        		'select2Options' => ['theme' => Select2::THEME_DEFAULT,],
		            'pluginOptions'=>[
		                'depends'=>['componentehardware-modelo_componente_hardware_id'],
		                'placeholder'=> '',
		                'initialize' => Yii::$app->request->get('modelo_componente_hardware_id') != null || !$model->isNewRecord,
		                'url'=>Url::to(['/componente-hardware/estados']),
		            ],
		            'pluginEvents' => [
		                'init' => 'console.log("init")',
		                'ready' => 'console.log("ready")',
		                'change' => 'function() {
		                                console.log("change"); 
		                                if ($(this).val() == "'. $model::IN_USE .'"){
		                                    $(".field-componentehardware-activo_hardware_id").show("slow");
		                                }
		                                else{
		                                    $(".field-componentehardware-activo_hardware_id").hide("slow");
		                                }
		                            }'
		            ]
		        ]) ?>
		
		        
		        <?= $model->isNewRecord ? '' : $form->field($model, 'modelo_componente_hardware_id')->hiddenInput()->label(''); ?>
            </div>
               
            <div class="box-footer">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-epi-green btn-flat']) ?>
                    <?= Html::a(Yii::t('app', 'Cancel'),Yii::$app->request->referrer , ['class' => 'btn btn-default btn-flat']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div id="seriales" class="col-md-6" style="display:none">
	</div>
    
    <div class="col-md-6 <?= $model->IsNewRecord ? 'hidden' : '' ?>">
        <?= DynamicRelations::widget([
        	'boxClass' => 'epi-blue',
        	'header' => 'h3',
            'title' => Yii::t('app','Parts'),
            'collection' => $model->partesComponenteHardware,
            'viewPath' => '@app/views/parte-componente-hardware/_inline.php',
            'params' => ['parent_id' => $model->id],
            'panelId' => 'componentes',
            
            // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
            'collectionType' => new app\models\ParteComponenteHardware,

        ]); ?>
    </div>
       
</div>


<?php ActiveForm::end(); ?>
        