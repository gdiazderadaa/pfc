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

    <div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-info"></i><?= Yii::t('app','About')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','{modelClass} stand for every physical component, such as desktops, laptops, screens, etc.',['modelClass' => $searchModel->pluralObjectName()]) ?></li>
	    	<li><?= Yii::t('app','Every {modelClass} has a unique {codigo}, {nombre}, {categoria}, {fecha_compra}, {precio_compra} and {espacio}.',
	    						[
	    							'modelClass' => $searchModel->singularObjectName(),
	    							'codigo' => $searchModel->getAttributeLabel('codigo'),
    								'nombre' => $searchModel->getAttributeLabel('nombre'),
    								'categoria' => $searchModel->getAttributeLabel('categoria_id'),
    								'fecha_compra' => $searchModel->getAttributeLabel('fecha_compra'),
    								'precio_compra' => $searchModel->getAttributeLabel('precio_compra'),
    								'espacio' => $searchModel->getAttributeLabel('espacio_id'),
	    	]) ?></li>
	    </ul>    
	</div>

	<div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','To add a new {modelClass} click on the "Create" button on the top right of the list.',['modelClass' => $searchModel->singularObjectName()]) ?></li>
	    	<li><?= Yii::t('app','To clone, view the full details, update or delete an existing {modelClass} click on one of the icons located at the end of each row',['modelClass' => $searchModel->singularObjectName()]) ?></li>
	    	<li><?= Yii::t('app','To attach a {modelClass} click on the view icon located at the end of each row and select Attach Hardware Component from the actions dropdown',[
	    					'modelClass' => \app\models\ComponenteHardware::singularObjectName()
	    	]) ?></li>
	    </ul>    
	</div>

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
                    <i class="fa fa-sitemap"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Categories') ?></span>
                    <span class="info-box-number"><?= app\models\ActivoHardware::find()->joinWith('parent')->select('categoria_id')->distinct()->count() ?></span>
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
                    <span class="info-box-number"><?= Yii::$app->formatter->asCurrency(app\models\ActivoHardware::find()->joinWith('parent')->sum('precio_compra')) ?></span>
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
			        				'filterInputOptions'=>['placeholder'=>Yii::t('app','Any {modelClass}',['modelClass' => $searchModel->nombre])],
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
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any {modelClass}',['modelClass' => $searchModel->categoria_id])],
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
					                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any {modelClass}',['modelClass' => $searchModel->espacio_id])],
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
