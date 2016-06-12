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
                            ['label' => Yii::t('app', 'Delete'), 'url' => ['delete', 'id' => $model->id]],
                        	['label' => Yii::t('app', 'Create New'), 'url' => ['create']],
                            ['label' => Yii::t('app', 'Create Hardware Component(s)'), 'url' => ['componente-hardware/create', 'modelo_componente_hardware_id' => $model->id]],
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>
    
    <div class="row">
       <div class="col-sm-2 pull-right">
            <div class=" info-box-sm">
                <span class="info-box-icon bg-epi-orange">
                    <i class="fa fa-cubes"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"></span>
                    <span class="info-box-number info-box-number-sm"></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-money"></i>
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
                    <i class="fa fa-calendar"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"></span>
                    <span class="info-box-number"></span>
                </div>
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
				                'value' => $model->espacio ? $model->espacio->nombre : ""
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
                        				return  $model->activoSoftware->nombre; } ,    
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
                        'dataProvider' => $configuraciones,
                        'label' => function($model){ 
                        				return  $model->modelo->categoria->nombre; } ,
                        'value' => function($model){ 
                        				return  $model->modelo->nombre; } ,    
                    ]) ?>
                </div>
            </div> 
        </div>
                 
    </div>
     

</div>

				    
				    
				    
				    
				    
				    
				    
				    
				    