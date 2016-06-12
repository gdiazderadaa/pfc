<?php

use app\common\widgets\KeyValueListView;
use kartik\dropdown\DropdownX;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloComponenteHardware */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-componente-hardware-view">

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
                    <span class="info-box-text"><?= app\models\ComponenteHardware::pluralObjectName() ?></span>
                    <span class="info-box-number info-box-number-sm"><?= $model->cantidad ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-money"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Total cost') ?></span>
                    <span class="info-box-number"><?= Yii::$app->formatter->asCurrency($model->costeTotal) ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-brown">
                    <i class="fa fa-calendar"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Out of warranty') ?></span>
                    <span class="info-box-number"><?= $model->totalGarantiaExpirada ?></span>
                </div>
            </div>
        </div>
    </div>
   
    <div class="row">
        
        <div class="col-md-12 <?= $model->inventario ? '' : 'hidden' ?>">
            <div class="box box-epi-gold">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= \app\models\ComponenteHardware::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive">
                    <?= GridView::widget([
                        'bordered' => false,
                        'striped' => false,
                        'tableOptions' => [
                            'class' => 'table table-hover',
                        ],
                        'dataProvider' => $model->getComponentesHardwareDataProvider($model->id),
                        'columns' => [
                        [
                                'attribute' => 'numero_serie',
                                'value'=>function ($model, $key, $index, $widget) { 
                                    return Html::a($model->numero_serie,  
                                        ['componente-hardware/view', 'id' => $model->id], 
                                        ['title'=>Yii::t('app','View Hardware Component details')]);
                                },
                                'format'=>'raw',
                                'width' => '22%'  
                            ],           
                            [
                                'attribute' => 'estado', 
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter'=>ArrayHelper::map(app\models\ComponenteHardware::find()->orderBy('estado')->asArray()->all(), 'estado', 'estado'),
                                'filterWidgetOptions'=>[
                                    'pluginOptions'=>['allowClear'=>true],
                                ],
                                'filterInputOptions'=>['placeholder'=>Yii::t('app','Any Status')],
                                'width' => '20%'
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
                                'format'=>'raw',
                                'width' => '22%'
                            ],
                                                    
                            [
                                'attribute' => 'fecha_compra',
                                'format' => 'date',
                                'width' => '12%',
                                'hAlign' => 'center',
                            ],
                            
                            [
                                'attribute' => 'meses_garantia',
                                'label' => Yii::t('app','Warrany (Months)'),
                                'hAlign' => 'right',
                                'width' => '12%'
                            ],
                            
                            [
                            	'class' => '\kartik\grid\BooleanColumn',
                            	'attribute' => 'enGarantia'
                            ],
                            
                            [
	                            'attribute' => 'precio_compra',
	                            'format' => 'currency',
	                            'hAlign' => 'right',
	                            'width' => '12%'
                            ],
                        ],
                    ]); ?>
                </div>
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
                            'marca',
                            'modelo',
                            [
                                'label' => $model->getAttributeLabel('categoria_id'), 
                                'value' => $model->categoria->nombre
                            ],
                            'inventario:boolean'
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
                    	'emptyText' => Yii::t('app','This model has no features yet'),
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

