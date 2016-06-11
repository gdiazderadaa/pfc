<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EdificioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js = <<<JS
$(function() {
    $('.floors-view-link').click(function(e) {
        e.preventDefault();
    });
});
JS;

$this->title = $searchModel->pluralObjectName();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edificio-index">

    <div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-info"></i><?= Yii::t('app','About')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','Buildings are intended to represent actual buildings within a University.') ?></li>
	    	<li><?= Yii::t('app','Every Building has a unique name, an address and an optional image.') ?></li>
	    </ul>    
	</div>

	<div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
	    <ul>
	    	<li><?= Yii::t('app','To add a new Building click on the "Create" button on the top right of the list.') ?></li>
	    	<li><?= Yii::t('app','To view the floors, the full details, update or delete an existing Building click on one of the icons located at the end of each row') ?></li>
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
				            		'filter'=>ArrayHelper::map(app\models\Edificio::find()->orderBy('nombre')->asArray()->all(), 'nombre', 'nombre'),
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
					        		'attribute' => 'localidad',
					        		'filterType' => GridView::FILTER_SELECT2,
					        		'filter'=>ArrayHelper::map(app\models\Edificio::find()->orderBy('localidad')->asArray()->all(), 'localidad', 'localidad'),
					        		'filterWidgetOptions'=>[
					        				'pluginOptions'=>['allowClear'=>true],
					        				'theme' => Select2::THEME_DEFAULT,
					        		],
					        		'filterInputOptions'=>[
					        				'placeholder'=>Yii::t('app','Any {modelClass}' ,[
					        						'modelClass' => $searchModel->attributeLabels()['localidad']
					        						 
					        				])
					        		],
				        		],
					        		
					             [
					                'attribute' => 'imagen',
					                'format' => 'html',
				             		'filter' => false,
					                'value' => function($data) {
					                    return Html::img( $data->imageUrl, [
					                        'width' => '200px',
					                        'alt' => $data->nombre,
					                        'title' => $data->nombre,
					                    ]); }
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
					            						['edificio/view-plantas', 'id' => $model->id],
					            						[
					            								'title' => $model->nombre,
					            								'class' => 'show-modal floors-view-link',
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
