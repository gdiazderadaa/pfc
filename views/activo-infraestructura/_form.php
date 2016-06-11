<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\ValidationAsset;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use synatree\dynamicrelations\DynamicRelations;
ValidationAsset::register($this);

use app\models\Espacio;
use app\models\Edificio;
use app\models\PlantaEdificio;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert alert-info-white alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
    <ul>
    	<li><?= Yii::t('app','Enter the Asset Tag, Name, Category, Purchase Date, Purchase Price, Status and Room.') ?></li>
    	<li><?= Yii::t('app','Add as many features as you want.') ?></li>
    	<li><?= Yii::t('app','Click on the "Create" button to finsh') ?></li>
    </ul> 
</div>

<?php $form = ActiveForm::begin(['id' => 'activo-infraestructura-form']); ?>

<div class="row">
    <div class="col-md-6">
		<div class="activo-infraestructura-form box box-epi-green">
		
		<div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">

                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
         
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
         
		         <div class="row">
			        <div class="col-md-6">
		                <?= $form->field($model, 'categoria_id')->widget(Select2::classname(), [
		                    'data' => $model->getCategorias(),
		                	'theme' => Select2::THEME_DEFAULT,
		                	'options' => ['placeholder' => ''],
		                	'pluginOptions' => ['allowClear' => true,]
		                ]); ?>
					</div>
					
					<div class="col-md-6">
						<?= $form->field($model, 'estado')->widget(Select2::classname(), [
		                    'data' => $model->getEstados(),
		                	'theme' => Select2::THEME_DEFAULT,
		                	'options' => ['placeholder' => ''],
		                	'pluginOptions' => ['allowClear' => true,]
		                ]); ?>
					</div>
				</div>
                
            	<div class="row">
			        <div class="col-md-6">
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
			        

			        <div class="col-md-6">
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
				
				<div class="form-group">
					<label class="control-label" for="edificio-id"><?=Edificio::singularObjectName()?></label>
	                <?php echo Select2::widget([
	                		'theme' => Select2::THEME_DEFAULT,
	                         'options'=>[
	                            'id'=>'edificio-id',
                         		'placeholder' => Yii::t('app','Select ...')
	                         ],
                			'pluginOptions' => [
                				'allowClear' => true,
                				'initialize' => $model->isNewRecord ? false : true,
                			],
	                          'name' => 'edificio',
	                          'data' => Edificio::getEdificios(),
	                          'value' => $model->isNewRecord ? '' : $model->espacio->plantaEdificio->edificio_id
	                ]); ?>
                </div>
                
                <div class="form-group">
			        <div class="form-group row">
			            <div class="col-md-4">
			                <label class="control-label" for="planta-edificio-id"><?=PlantaEdificio::singularObjectName()?></label>
			                <?php echo DepDrop::widget([
                                        'options'=>['id'=>'planta-edificio-id'],
                                        'name' => 'planta-edificio',
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'data' => $model->isNewRecord ? [] : [$model->espacio->planta_edificio_id => $model->espacio->plantaEdificio->nombre],
                                        'pluginOptions'=>[
                                        		'allowClear' => true,
                                            'initialize' => $model->isNewRecord ? false : true,
                                            'depends'=>['edificio-id'],
                                            'url'=>Url::to(['/planta-edificio/plantas-by-edificio'])
                                        ],
			                			'select2Options' => ['theme' => Select2::THEME_DEFAULT,]
                                    ]); ?>
			            </div>
			            
			            <div class="col-md-8">
			                <?= $form->field($model, 'espacio_id')->widget(DepDrop::classname(), [
			                    'type' => DepDrop::TYPE_SELECT2,
			                    'data' => $model->isNewRecord ? [] : [$model->espacio_id => $model->espacio->nombre],
			                    'pluginOptions'=>[
			                    		'allowClear' => true,
			                        'initialize' => $model->isNewRecord ? false : true,
			                        'depends'=>['planta-edificio-id'],
			                        'url'=>Url::to(['/espacio/espacios-by-planta-edificio'])
			                    ],
		                		'select2Options' => ['theme' => Select2::THEME_DEFAULT,]
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
    
    <div class="col-md-6">
        <?= DynamicRelations::widget([
            'boxClass' => 'epi-blue',
            'header' => 'h3',
            'title' => Yii::t('app','Features'),
            'collection' => $model->valoresCaracteristicasActivoInventariable,
            'viewPath' => '@app/views/valor-caracteristica-activo-inventariable/_inline.php',
            'params' => [
                'tipo_activo' => $model->tipo,
                
            ],
            
            // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
            'collectionType' => new app\models\ValorCaracteristicaActivoInventariable,

        ]); ?>    
    </div>

</div>


<?php ActiveForm::end(); ?>