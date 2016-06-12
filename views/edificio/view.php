<?php

use yii\widgets\DetailView;
use kartik\dropdown\DropdownX;
use app\common\widgets\KeyValueListView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Edificio */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="edificio-view">



    <div class="row">
        <div class="col-md-12 buttons-container">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-flat btn-epi-green"><?= Yii::t('app','Actions') ?> <b class="caret"></b></button>
                <?php
                    echo DropdownX::widget([
                        'items' => [
                            ['label' => Yii::t('app', 'Update'), 'url' => ['update', 'id' => $model->id]],
                            ['label' => Yii::t('app', 'Delete'), 'url' => ['delete', 'id' => $model->id]],
                        	['label' => Yii::t('app', 'Create New'), 'url' => ['create']],
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>
    
    <div class="alert alert-info-white alert-dismissible" >
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
	    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
	    <p><?= Yii::t('app','Click on the images to view them in full size') ?>
	</div>


    <div class="row">
        
        <div class="col-md-6">         
            <div class="box box-epi-green">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','Details') ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
	                <?= newerton\fancybox\FancyBox::widget([
					    'target' => 'a[rel=fancybox]',
					    'helpers' => true,
					    'mouse' => true,
					    'config' => [
					        'maxWidth' => '90%',
					        'maxHeight' => '90%',
					        'arrows' => false,
					        'openOpacity' => true,
					        'helpers' => [
					            'title' => ['type' => 'outside'],
					            'overlay' => [
					                'css' => [
					                    'background' => 'rgba(0, 0, 0, 0.8)'
					                ]
					            ]
					        ],
					    ]
					]);?>
				    <?php $title = isset($model->ruta_imagen) && !empty($model->ruta_imagen) ? $model->ruta_imagen : $model->nombre; ?>
				    <?= DetailView::widget([
			    		'options' =>[
			    				'class' => 'table table-hover details'
			    		],
				        'model' => $model,
				        'attributes' => [
				            'nombre:ntext',
				            'localidad:ntext',

			        		[
				        		'attribute' => $model->attributeLabels()['imagen'],
				        		'format' =>'raw',
		        				'value' => Html::a(Html::img($model->getImageUrl(),['class'=>'img-thumbnail',
																        				'alt'=>$title,
																        				'title'=>$title,]),
		        									$model->getImageUrl(),
	        										['rel' => 'fancybox','title'=>$title])
	        				],
				        ],
				    ]) ?>
                </div>
            </div>
        </div>
            
        <div class="col-md-6">
            <div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= \app\models\PlantaEdificio::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','This {modelClass} has no {features} yet',[
                    						'modelClass' => $model->singularObjectName(),
                    						'features' => app\models\PlantaEdificio::pluralObjectName()
                    					]),
                        'dataProvider' => $dataProvider,
                        'label' => function($model){ return $model->nombre ; }   ,
						'format' => 'raw',
						'value' => function($model){ 
                        				return Html::a(Html::img($model->getImageUrl(),['class'=>'img-thumbnail',
																        				'alt'=>$model->nombre,
																        				'title'=>$model->nombre,]),
		        									$model->getImageUrl(),
	        										['rel' => 'fancybox','title'=>$model->nombre]); }     
                    ]) ?>
                </div>
            </div>            
        </div>
                 
    </div>
				    
				   
</div>
