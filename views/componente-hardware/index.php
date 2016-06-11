<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\ModeloComponenteHardware;
use app\models\ComponenteHardware;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ComponenteHardwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="componente-hardware-index">

   <div class="row">
       <div class="col-sm-2 pull-right">
            <div class=" info-box-sm">
                <span class="info-box-icon bg-epi-orange">
                    <i class="fa fa-cubes"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Total') ?></span>
                    <span class="info-box-number"><?= ComponenteHardware::find()->count() ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-link"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Used in {modelClass}',['modelClass'=> app\models\ActivoHardware::pluralObjectName()]) ?></span>
                    <span class="info-box-number"><?= ComponenteHardware::find()->where(['not',['activo_hardware_id' => null]])->count() ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-brown">
                    <i class="fa fa-money"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Total cost') ?></span>
                    <span class="info-box-number"><?= Yii::$app->formatter->asCurrency(ComponenteHardware::find()->sum('precio_compra')) ?></span>
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
					                'attribute' => 'marcaModeloComponenteHardware',
					                'filterType' => GridView::FILTER_SELECT2,
					                'filter'=>ArrayHelper::map(ModeloComponenteHardware::find()->orderBy('marca')->asArray()->all(), 'marca', 'marca'),
					                'filterWidgetOptions'=>[
					            				'pluginOptions'=>['allowClear'=>true],
					            				'theme' => Select2::THEME_DEFAULT,
									            		],
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Manufacturer')], 
					                //'group'=>true,   
					            ],
					            [
					                'attribute' => 'modeloModeloComponenteHardware',
					                'value'=>function ($model, $key, $index, $widget) { 
					                    return Html::a($model->modeloModeloComponenteHardware,  
					                        ['modelo-componente-hardware/view', 'id' => $model->modelo_componente_hardware_id], 
					                        ['title'=>Yii::t('app','View Model details')]);
					                },
					                'filterType' => GridView::FILTER_SELECT2,
					                'filter'=>ArrayHelper::map(ModeloComponenteHardware::find()->orderBy('modelo')->asArray()->all(), 'modelo', 'modelo'),
					                'filterWidgetOptions'=>[
					            				'pluginOptions'=>['allowClear'=>true],
					            				'theme' => Select2::THEME_DEFAULT,
									            		],
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Model')], 
					                //'group'=>true,
					                'format'=>'raw'   
					            ],
					            
					            'numero_serie',
					          
					            [
					                'attribute' => 'estado', 
					                'filterType' => GridView::FILTER_SELECT2,
					                'filter'=>ArrayHelper::map(app\models\ComponenteHardware::find()->orderBy('estado')->asArray()->all(), 'estado', 'estado'),
					                'filterWidgetOptions'=>[
					            				'pluginOptions'=>['allowClear'=>true],
					            				'theme' => Select2::THEME_DEFAULT,
									            		],
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Status')],
					            ],
					                      
					            [
					            	'attribute' => 'fecha_compra',
					            	'format' => 'date',
					            	'hAlign' => 'center'
					            ],
					            
					            [
					                'attribute' => 'meses_garantia',
					                'label' => Yii::t('app','Warrany (Months)'),
					            	'hAlign' => 'right'
					            ],
					                      
					            [
					            	'attribute' => 'precio_compra',
					            	'format' => 'currency',
					            	'hAlign' => 'right'
					            ],
					            
					            [
					                 'attribute' => 'activo_hardware_id',
					                 'value' => 'activoHardware.nombre',
					                 'value'=>function ($model, $key, $index, $widget) { 
					                     if ($model->activoHardware != null) {
					                         return Html::a($model->activoHardware->nombre,  
					                            ['activo-hardware/view', 'id' => $model->activo_hardware_id], 
					                            ['title'=>Yii::t('app','View Hardware Asset details')]);
					                     } else {
					                         return null;
					                     }    
					                },
					                'format'=>'raw'
					            ],
					
					            [
					                'class' => '\kartik\grid\ActionColumn',
					                'mergeHeader' => false,
					            	'header'=>'',
					            	'width' => '90px',
					            	'template' => '{clone}{view}{update}{delete}',
					                'buttons' => [
					                		'clone' => function ($url, $model) {
															    return Html::a(
															        '<span class="fa fa-clone"></span>',
															        ['componente-hardware/clone', 'id' => $model->id], 
															        [
															            'title' => Yii::t('app','Clone'),
														        		'data-pjax' => '0',		
														        		'aria-label' => Yii::t('app','Clone'),
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
