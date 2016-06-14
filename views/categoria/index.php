<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">

    <div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-info"></i><?= Yii::t('app','About')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','{modelClass} are intended to classify hardware, software and infrastructure assets into smaller groups.',['modelClass' => $searchModel->pluralObjectName()]) ?></li>
	    	<li><?= Yii::t('app','Every {modelClass} has a unique {name} and applies to a type of {asset} / {component model}.',[
				    			'modelClass' => $searchModel->singularObjectName(),
				    			'name' => $searchModel->getAttributeLabel('nombre'),
	    						'asset' => app\models\ActivoInventariable::singularObjectName(),
	    						'component model' => app\models\ComponenteHardware::singularObjectName()
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
				            		'filter'=>ArrayHelper::map(app\models\Categoria::find()->orderBy('nombre')->asArray()->all(), 'nombre', 'nombre'),
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
					            	'attribute' => 'tipo',
				            		'filterType' => GridView::FILTER_SELECT2,
				            		'filter'=>ArrayHelper::map(app\models\Categoria::find()->orderBy('tipo')->asArray()->all(), 'tipo', 'tipo'),
				            		'filterWidgetOptions'=>[
				            				'pluginOptions'=>['allowClear'=>true],
				            				'theme' => Select2::THEME_DEFAULT,
				            		],
				            		'filterInputOptions'=>[
				            				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
				            						'modelClass' => $searchModel->attributeLabels()['tipo']
				            						 
				            				])
				            		],
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
