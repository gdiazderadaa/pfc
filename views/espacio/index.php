<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EspacioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espacio-index">

    <div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-info"></i><?= Yii::t('app','About')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','{modelClass} are every single space within a building floor, suitable to contain assets.',['modelClass' => $searchModel->pluralObjectName()]) ?></li>
	    	<li><?= Yii::t('app','Every {modelClass} has a unique {number}, a {name} and the {floor} where is located.',[
	    						'modelClass' => $searchModel->singularObjectName(),
	    						'name' => $searchModel->getAttributeLabel('numeracion'),
	    						'number' => $searchModel->getAttributeLabel('nombre'),	
	    						'floor' => $searchModel->getAttributeLabel('planta_edificio_id'),
	    	]) ?></li>
	    </ul>    
	</div>

	<div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','To add a new {modelClass} click on the "Create" button on the top right of the list.',['modelClass' => $searchModel->singularObjectName()]) ?></li>
	    	<li><?= Yii::t('app','To view the full details, update or delete an existing {modelClass} click on one of the icons located at the end of each row',['modelClass' => $searchModel->singularObjectName()]) ?></li>
	    </ul>   
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
					            	'attribute' => 'nombre',
				            		'filterType' => GridView::FILTER_SELECT2,
				            		'filter'=>ArrayHelper::map(app\models\Espacio::find()->orderBy('nombre')->asArray()->all(), 'nombre', 'nombre'),
				            		'filterWidgetOptions'=>[
				            				'pluginOptions'=>['allowClear'=>true],
				            				'theme' => Select2::THEME_DEFAULT,
				            		],
				            		'filterInputOptions'=>[
				            				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
				            						'modelClass' => $searchModel->attributeLabels()['nombre']
				            						 
				            				])
				            		],
					   			 ],
					            
				        		[
					        		'attribute' => 'numeracion',
					        		'filterType' => GridView::FILTER_SELECT2,
					        		'filter'=>ArrayHelper::map(app\models\Espacio::find()->orderBy('numeracion')->asArray()->all(), 'numeracion', 'numeracion'),
					        		'filterWidgetOptions'=>[
					        				'pluginOptions'=>['allowClear'=>true],
					        				'theme' => Select2::THEME_DEFAULT,
					        		],
					        		'filterInputOptions'=>[
					        				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
					        						'modelClass' => $searchModel->attributeLabels()['numeracion']
					        						 
					        				])
					        		],
				        		],
					        		
					            [
					                'attribute' => 'planta_edificio_id',
					                'value' => 'plantaEdificio.nombre',
				            		'filterType' => GridView::FILTER_SELECT2,
				            		'filter'=>ArrayHelper::map(app\models\PlantaEdificio::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'),
				            		'filterWidgetOptions'=>[
				            				'pluginOptions'=>['allowClear'=>true],
				            				'theme' => Select2::THEME_DEFAULT,
				            		],
				            		'filterInputOptions'=>[
				            				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
				            						'modelClass' => $searchModel->attributeLabels()['planta_edificio_id']
				            		
				            				])
				            		],
					            ],
					        		
					            [
					            	'attribute' => 'edificio_id',
					                'value' => 'plantaEdificio.edificio.nombre',
				            		'filter' => false,
// 				            		'filterType' => GridView::FILTER_SELECT2,
// 				            		'filter'=>ArrayHelper::map(app\models\Edificio::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'),
// 				            		'filterWidgetOptions'=>[
// 				            				'pluginOptions'=>['allowClear'=>true],
// 				            				'theme' => Select2::THEME_DEFAULT,
// 				            		],
// 				            		'filterInputOptions'=>[
// 				            				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
//  				            						'modelClass' => $searchModel->attributeLabels()['edificio_id'],
// 				            						'modelClass' => $searchModel->attributeLabels()['edificio_id']
				            		
// 				            				])
// 				            		],
					             ],
					             
					
					            [
				            		'class' => '\kartik\grid\ActionColumn',
				            		'mergeHeader' => false,
				            		'header'=>'',
				            		'width' => '90px',
			            		],
					        ],
					    ]); ?>
				    <?php Pjax::end(); ?>
				</div>
			</div>
		</div>
		
	</div>
	
</div>
