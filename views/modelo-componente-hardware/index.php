<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\ModeloComponenteHardware;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModeloComponenteHardwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js = <<<JS
$(function() {
    $('.features-view-link').click(function(e) {
        e.preventDefault();
    });
});
JS;
 
$this->registerJs($js);


$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-componente-hardware-index">

   <div class="row">
       <div class="col-sm-2 pull-right">
            <div class=" info-box-sm">
                <span class="info-box-icon bg-epi-orange">
                    <i class="fa fa-cubes"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Total') ?></span>
                    <span class="info-box-number"><?= ModeloComponenteHardware::find()->count() ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-link"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Used') ?></span>
                    <span class="info-box-number"><?= \app\models\ComponenteHardware::find()->select('modelo_componente_hardware_id')->distinct()->count() ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-brown">
                    <i class="fa fa-barcode"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Inventory on') ?></span>
                    <span class="info-box-number"><?= ModeloComponenteHardware::find()->where(['inventario' => true])->count() ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-12">
            <div class="box box-epi-gold">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app','{modelClass} list',['modelClass' => $searchModel::pluralObjectName()])?></h3>
                	<div class="btn-group pull-right">
                	<?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'Create'),
													['create'],
													['data-pjax'=>0, 'class' => 'btn btn-epi-green', 'title'=>Yii::t('app', 'Create')]) 
					.''.
					Html::a('<i class="fa fa-repeat"></i> '.Yii::t('app', 'Reset filters'), 
													['index'], 
													['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset filters')]) ?>	
                	</div>
                </div>
                <div class="box-body table-responsive">

					<?php Pjax::begin(); ?>    
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'pager' => [
									'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
							],
							'summaryOptions' => ['class' => 'pull-left'],
							'pjax'=>true,
							'bordered' => false,
							'striped' => false,
							'layout' => '{items}{summary}{pager}',
							'tableOptions' => [
									'class' => 'table table-hover',
							],
					        'columns' => [           
					            [
					                'attribute' => 'categoria_id',
				            		'filterType' => GridView::FILTER_SELECT2,
				            		'filter'=>ArrayHelper::map(app\models\Categoria::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'),
				            		'filterWidgetOptions'=>[
			            				'pluginOptions'=>['allowClear'=>true],
			            				'theme' => Select2::THEME_DEFAULT,
				            		],
				            		'value' => 'categoria.nombre',
				            		'filterInputOptions'=>[
			        						'placeholder'=>Yii::t('app','Any {modelClass}' ,[
			        														'modelClass' => $searchModel->attributeLabels()['categoria_id']
			        						
			        													])
			        				],
					            ],
					        		
				        		[
				        			'attribute' => 'marca',
			        				'filterType' => GridView::FILTER_SELECT2,
			        				'filter'=>ArrayHelper::map(app\models\ModeloComponenteHardware::find()->orderBy('marca')->asArray()->all(), 'marca', 'marca'),
			        				'filterWidgetOptions'=>[
			        						'pluginOptions'=>['allowClear'=>true],
			        						'theme' => Select2::THEME_DEFAULT,
			        				],
			        				'filterInputOptions'=>[
			        						'placeholder'=>Yii::t('app','Any {modelClass}' ,[
			        														'modelClass' => $searchModel->attributeLabels()['marca']
			        						
			        													])
			        				],
			            		],
					            
					            [
				        			'attribute' => 'modelo',
			        				'filterType' => GridView::FILTER_SELECT2,
			        				'filter'=>ArrayHelper::map(app\models\ModeloComponenteHardware::find()->orderBy('modelo')->asArray()->all(), 'modelo', 'modelo'),
			        				'filterWidgetOptions'=>[
			        						'pluginOptions'=>['allowClear'=>true],
			        						'theme' => Select2::THEME_DEFAULT,
			        				],
			        				'filterInputOptions'=>[
			        						'placeholder'=>Yii::t('app','Any {modelClass}' ,[
			        														'modelClass' => $searchModel->attributeLabels()['modelo']
			        						
			        													])
			        				],
			            		],
					        		
				        		[
				        				'class' => '\kartik\grid\BooleanColumn',
				        				'attribute' => 'inventario',
								],
				        			
				        		[
			        				'attribute' => 'cantidad',
			        				'width' => '90px',
			        				'hAlign' => 'right'
					            ],
					            
					            [
				            		'class' => '\kartik\grid\ActionColumn',
			            			'mergeHeader' => false,
				            		'header'=>'',
				            		'width' => '90px',
				            		'template' => '{features} {view} {update} {delete}',
				            		'buttons' => [
				            				'features' => function ($url, $model) {
															    return Html::a(
															        '<span class="glyphicon glyphicon-list-alt"></span>',
															        ['modelo-componente-hardware/view-caracteristicas', 'id' => $model->id], 
															        [
															            'title' => $model->nombre,
 															            'class' => 'show-modal features-view-link',
														        		'data-pjax' => '0',		
														        		'aria-label' => 'View features'
															    ] 
														    	);
															},
									]
					            		
		                        ],
					        ],
					    ]); ?>
					<?php Pjax::end(); ?>
				</div>
			</div>
		</div>
		
	</div>
	
</div>
