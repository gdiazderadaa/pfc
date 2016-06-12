<?php

use yii\helpers\Html;
use kartik\dropdown\DropdownX;
use yii\widgets\DetailView;
use app\common\widgets\KeyValueListView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-view">

    <div class="row">
        <div class="col-md-12 buttons-container">
		    <div class="btn-group">
		        <button data-toggle="dropdown" class="btn btn-epi-green"><?= Yii::t('app','Actions') ?> <b class="caret"></b></button>
		        <?php
		            echo DropdownX::widget([
		                'items' => [
		                    ['label' => Yii::t('app', 'Update'), 'url' => ['update', 'id' => $model->id]],
		                    ['label' => Yii::t('app', 'Delete'), 'url' => ['delete', 'id' => $model->id]],
                        	['label' => Yii::t('app', 'Create New'), 'url' => ['create']],
	                		['label' => Yii::t('app', 'Clone'), 'url' => ['clone', 'id' => $model->id]],
		                ],
		            ]);
		        ?>
		    </div>
	    </div>
    </div>

	<div class="row">
        
        <div class="col-md-6">         
            <div class="box box-epi-green">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','Details') ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
    
				    <?= DetailView::widget([
			    		'options' =>[
			    				'class' => 'table table-hover details'
			    		],
				        'model' => $model,
				        'attributes' => [
				            'codigo',
				            'nombre',
				            [
				                'label' => $model->getAttributeLabel('categoria_id'),
				                'value' => $model->categoria->nombre
				            ],
				            [
				                'label' => $model->parent->getAttributeLabel('fecha_compra'),
				                'value' => Yii::$app->formatter->asDate($model->fecha_compra)
				            ],
				            [
				                'label' => $model->parent->getAttributeLabel('precio_compra'), 
				                'value' => Yii::$app->formatter->asCurrency($model->precio_compra)
				            ],
				            [
				                'label' => $model->parent->getAttributeLabel('espacio_id'),
				                'value' => $model->espacio ? $model->espacio->nombre : ""
				            ],
				        ],
				    ]) ?>
            	</div>
            </div>
        </div>
            
        <div class="col-md-6">
            <div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= \app\models\Caracteristica::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','This {modelClass} has no {features} yet',[
                    						'modelClass' => $model->singularObjectName(),
                    						'features' => app\models\Caracteristica::pluralObjectName()
                    					]),
                        'dataProvider' => $dataProvider,
                        'label' => function($model){ 
                        				return  $model->caracteristica->unidades != null ? 
                        						$model->caracteristica->nombre.'('.$model->caracteristica->unidades.')' 
												: $model->caracteristica->nombre; } ,
                        'value' => 'valor',     
                    ]) ?>
                </div>
            </div>            
        </div>
                 
    </div>

</div>