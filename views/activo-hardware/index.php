<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\ActivoHardware;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivoHardwareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-hardware-index">

   <div class="row">
       <div class="col-sm-2 pull-right">
            <div class=" info-box-sm">
                <span class="info-box-icon bg-epi-orange">
                    <i class="fa fa-cubes"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Total') ?></span>
                    <span class="info-box-number"><?= ActivoHardware::find()->count() ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-link"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"></span>
                    <span class="info-box-number"></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-brown">
                    <i class="fa fa-barcode"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"></span>
                    <span class="info-box-number"></span>
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
					        //'filterModel' => $searchModel,
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
				        			'attribute' => 	'codigo',
// 			        				'filterType' => GridView::FILTER_SELECT2,
// 			        				'filter'=>ArrayHelper::map(app\models\ActivoHardware::find()->joinWith('parent')->orderBy('codigo')->asArray()->all(), 'codigo', 'codigo'),
// 			        				'filterWidgetOptions'=>[
// 		        						'pluginOptions'=>['allowClear'=>true],
// 		        						'theme' => Select2::THEME_DEFAULT,
// 			        				],
// 			        				'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Asset Number')],
					    		],
					            				        		[
				        			'attribute' => 	'nombre',
			        				'filterType' => GridView::FILTER_SELECT2,
			        				'filter'=>ArrayHelper::map(app\models\ActivoHardware::find()->joinWith('parent')->orderBy('nombre')->asArray()->all(), 'nombre', 'nombre'),
			        				'filterWidgetOptions'=>[
		        						'pluginOptions'=>['allowClear'=>true],
		        						'theme' => Select2::THEME_DEFAULT,
			        				],
			        				'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Asset Name')],
					    		],
					            [
					                'attribute' => 'categoria_id',
					                'value' => 'categoria.nombre',
				            		'filterType' => GridView::FILTER_SELECT2,
					                'filter'=>  ArrayHelper::map(app\models\Categoria::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'),
					                'filterWidgetOptions'=>[
					            				'pluginOptions'=>['allowClear'=>true],
					            				'theme' => Select2::THEME_DEFAULT,
									            		],
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Category')],
					            ],
					            [
					                'attribute' => 'fecha_compra',
					                'format'    => 'date',
				            		'hAlign' => 'center',
				            		'width' => '110px'
					            ],
					            [
					                'attribute' => 'precio_compra',
					                'format'    => 'currency',
					            	'hAlign' => 'right',
				            		'width' => '110px'
					            ],
					             [
					                'attribute' => 'espacio_id',
					                'value' => 'espacio.nombre',
				            		'filterType' => GridView::FILTER_SELECT2,
					                'filter'=>  ArrayHelper::map(app\models\Espacio::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'),
					                'filterWidgetOptions'=>[
					            				'pluginOptions'=>['allowClear'=>true],
					            				'theme' => Select2::THEME_DEFAULT,
									            		],
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Room')],
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
															        ['activo-hardware/clone', 'id' => $model->id], 
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
