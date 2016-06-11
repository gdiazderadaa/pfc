<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\ActivoInventariable;
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use kartik\widgets\DatePicker;

use app\models\Espacio;
use app\models\Edificio;
use app\models\PlantaEdificio;


$this->registerJs('function hideSoftware(){
                        console.log("Checking category...");
                        if ($("#activohardware-categoria_id option:selected" ).text() != "CPUs"){
                            console.log("Hiding panel...");
                            $("#configuracion-activo-hardware").hide();
                        }
                        else{
                            console.log("Showing panel...");
                            $("#configuracion-activo-hardware").show();
                        }
                    }
                    $("#activohardware-categoria_id").change(hideSoftware);'
                    , \yii\web\VIEW::POS_READY);
?>

<div class="alert alert-info-white alert-dismissible <?= !$model->isNewRecord ? 'hidden' : ''; ?>" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
    <ul>
    	<li><?= Yii::t('app','XXXXXXXXXX.') ?></li>
    	<li><?= Yii::t('app','XXXXXXXXXX.') ?></li>
    	<li><?= Yii::t('app','XXXXXXXXXX.') ?></li>
    	<li><?= Yii::t('app','To finish, click on the "Create" button') ?></li>
    </ul> 
</div>

<?php $form = ActiveForm::begin(['id' => 'activo-hardware-form']); ?>
<div class="row">
    <div class="col-md-6">
		<div class="activo-hardware-form box box-epi-green">
		
			<div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">

                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
         
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
         
                <?= $form->field($model, 'categoria_id')->widget(Select2::classname(), [
                    'data' => $model->getCategorias(),
                	'theme' => Select2::THEME_DEFAULT,
                ]); ?>

                
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


                <?= $form->field($model, 'estado')->widget(Select2::classname(), [     
                    'data' => $model->getEstados(),
                	'theme' => Select2::THEME_DEFAULT,
                ]); ?>
                

    
			    <div class="form-group">
			        <div class="form-group row">
			            <div class="col-md-4">
			                <label class="control-label" for="edificio-id"><?=Edificio::singularObjectName()?></label>
			                <?php echo Select2::widget([
                                        'options'=>[
                                            'id'=>'edificio-id',
                                            'placeholder' => Yii::t('app', '- Select the {modelClass} -', [
                                                'modelClass' =>  PlantaEdificio::attributeLabels()['edificio_id'],
                                                ]),
                                        ],
                                        'name' => 'edificio',
                                        'data' => Edificio::getEdificios(),
			                			'theme' => Select2::THEME_DEFAULT,
                                        'value' => $model->isNewRecord ? '' : $model->espacio->plantaEdificio->edificio_id
                                    ]); ?>
			            </div>
			
			            <div class="col-md-4">
			                <label class="control-label" for="planta-edificio-id"><?=PlantaEdificio::singularObjectName()?></label>
			                <?php echo DepDrop::widget([
                                        'options'=>['id'=>'planta-edificio-id'],
                                        'name' => 'planta-edificio',
                                        'type' => DepDrop::TYPE_SELECT2,
			                			'select2Options' => ['theme' => Select2::THEME_DEFAULT,],
                                        'data' => $model->isNewRecord ? [] : [$model->espacio->planta_edificio_id => $model->espacio->plantaEdificio->nombre],
                                        'pluginOptions'=>[
                                            'initialize' => $model->isNewRecord ? false : true,
                                            'depends'=>['edificio-id'],
                                            'placeholder'=> Yii::t('app', '- Select the {modelClass} -', [
                                                    'modelClass' => Espacio::attributeLabels()['planta_edificio_id'],
                                                    ]),
                                            'url'=>Url::to(['/planta-edificio/plantas-by-edificio'])
                                        ]
                                    ]); ?>
			            </div>
			            
			            <div class="col-md-4">
			                <?= $form->field($model, 'espacio_id')->widget(DepDrop::classname(), [
			                    'type' => DepDrop::TYPE_SELECT2,
			                    'data' => $model->isNewRecord ? [] : [$model->espacio_id => $model->espacio->nombre],
		                		'select2Options' => ['theme' => Select2::THEME_DEFAULT,],
		                		'pluginOptions'=>[
		                        'initialize' => $model->isNewRecord ? false : true,
		                        'depends'=>['planta-edificio-id'],
		                        'placeholder'=> Yii::t('app', '- Select the {modelClass} -', [
		                                'modelClass' => $model->attributeLabels()['espacio_id'],
		                                ]),
		                        'url'=>Url::to(['/espacio/espacios-by-planta-edificio'])
			                    ]
			                ]); ?>
			            </div>
			        </div>
    			</div>
    			
    		</div>
    			
    		<div class="box-footer">
	        	<div class="form-group">
	            	<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-epi-green btn-flat']) ?>
	                <?= Html::a(Yii::t('app', 'Cancel'),Yii::$app->request->referrer , ['class' => 'btn btn-default btn-flat']) ?>
                </div>
            </div>
    	</div>
    </div>
       
	<div class="col-md-6 <?= $model->tipo != 'Hardware' ? 'hidden' : '' ?>">
	    <?= DynamicRelations::widget([
	    	'boxClass' => 'epi-blue',
	    	'header' => 'h3',
	        'title' => Yii::t('app','Installed Software'),
	        'collection' => $model->configuracionesActivoHardware,
	        'viewPath' => '@app/views/configuracion-activo-hardware/_inline.php',
	        'params' => ['tipo_activo' => 'Hardware'],
	        'panelId' => 'configuracion-activo-hardware',
	
	        // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
	        'collectionType' => new app\models\ConfiguracionActivoHardware,
	
	    ]); ?>
    </div>
       
</div>


<?php ActiveForm::end(); ?>
