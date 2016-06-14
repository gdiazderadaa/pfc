<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\dropdown\DropdownX;
use app\common\widgets\KeyValueListView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoHardware */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-hardware-view">

    <div class="row">
        <div class="col-md-12 buttons-container">
            <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-flat btn-epi-green"><?= Yii::t('app','Actions') ?> <b class="caret"></b></button>
                <?php
                    echo DropdownX::widget([
                        'items' => [
                            ['label' => Yii::t('app', 'Update'), 'url' => ['update', 'id' => $model->id]],
                            ['label' => Yii::t('app', 'Delete'), 'url' => ['delete', 'id' => $model->id],
		                		'linkOptions' => ['data-method' => 'post', 'data-confirm' => Yii::t('app','Are you sure you want to delete this item?')]],
                        	['label' => Yii::t('app', 'Create New'), 'url' => ['create']],
                        	'<li class="divider"></li>',
                        	['label' => Yii::t('app', 'Clone'), 'url' => ['clone', 'id' => $model->id]],
                        	'<li class="divider"></li>',
                        	['label' => Yii::t('app', 'Attach Hardware Component'),
                        		'url'=> ['activo-hardware-componente-hardware/attach', 'id' => $model->id],
                        		'linkOptions' => ['id' => 'attach-child','data-submit' => Yii::t('app','Attach'), 'data-reload-container' => 'componente-hardware-view', 'class' => 'show-modal', 'title' => Yii::t('app','Select the component you want to attach to this asset')]],
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        
        <div class="col-md-4">         
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
			            		'value' => $model->espacio ? 
				            					Html::a($model->espacio->nombre,
					            				['espacio/view', 'id' => $model->espacio_id],
					            				['title'=>Yii::t('app','View {modelClass}',['modelClass' => $model->espacio->singularObjectName()])])
				            				:'',
	            				'format' => 'raw'
				            ],
				        ],
				    ]) ?>
                </div>
            </div>
        </div>
            
        <div class="col-md-4">
            <div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','Installed Software') ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','This {modelClass} has no {features} yet',[
                    		'modelClass' => $model->singularObjectName(),
                    		'features' => app\models\ActivoSoftware::pluralObjectName()
                    	]),
                        'dataProvider' => $configuraciones,
                        'label' => function($model){ 
                        				return  $model->activoSoftware->categoria->nombre; } ,
                        'value' => function($model){ 
                        				return Html::a($model->activoSoftware->nombre,
                        						['activo-software/view', 'id' => $model->activo_software_id],
                        						['title'=>Yii::t('app','View {modelClass}',['modelClass' => $model->activoSoftware->singularObjectName()])]);
                        			},
                        'format' => 'raw'
                    ]) ?>
                </div>
            </div>            
        </div>
        
        <div class="col-md-4">
        	<div class="box box-epi-gold">
                <div class="box-header">
                    <h3 class="box-title"><?= app\models\ComponenteHardware::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','This {modelClass} has no {features} yet',[
                   			'modelClass' => $model->singularObjectName(),
                    		'features' => app\models\ComponenteHardware::pluralObjectName()
                    	]),
                        'dataProvider' => $componentes,
                        'label' => function($model){ 
                        				return  $model->componenteHardware->modeloComponenteHardware->categoria->nombre; } ,
                        'value' => function($model){ 
                        				return Html::a($model->componenteHardware->modeloComponenteHardware->nombre,
                        						['componente-hardware/view', 'id' => $model->id],
                        						['title'=>Yii::t('app','View {modelClass}',['modelClass' => app\models\ComponenteHardware::singularObjectName()])]);
                        			},
                        'format' => 'raw'    
                    ]) ?>
                </div>
            </div> 
        </div>
                 
    </div>
     

</div>

				    
				    
				    
				    
				    
				    
				    
				    
				    