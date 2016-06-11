<?php

use yii\helpers\Html;
use kartik\dropdown\DropdownX;
use yii\widgets\DetailView;
use app\common\widgets\KeyValueListView;
use app\models\ActivoHardware;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espacio-view">

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

    <div class="row">
        
        <div class="col-lg-4">         
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
				            'nombre',
				            'numeracion',
				            [
				                'label' => $model->plantaEdificio->attributeLabels()['edificio_id'],
				                'value' => Html::a($model->plantaEdificio->edificio->nombre,  
				                                        ['edificio/view', 'id' => $model->plantaEdificio->edificio_id], 
				                                        ['title'=>Yii::t('app','View Building')]),
			            		'format' => 'raw'
				            ],
				            [
				                'label' => $model->attributeLabels()['planta_edificio_id'],
				                'value' => $model->plantaEdificio->nombre,
				            ],
				        ],
				    ]) ?>
                </div>
            </div>
        </div>
        
         <div class="col-lg-4">
        	<div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','{modelClass} in this Room',['modelClass' => app\models\ActivoInfraestructura::pluralObjectName()]) ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','There are no assets in this room'),
                        'dataProvider' => $activosInfraestructura,
                        'label' => function($model){ 
                        				return  $model->codigo; } ,
                        'value' => function($model){
                        				return  Html::a($model->nombre,
                        						['activo-infraestructura/view', 'id' => $model->id],
                        						['title'=>Yii::t('app','View Details')]);} ,
                        'format' => 'raw'  
                    ]) ?>
                </div>
            </div> 
        </div>
        
        <div class="col-lg-4">
        	<div class="box box-epi-gold">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','{modelClass} in this Room',['modelClass' => ActivoHardware::pluralObjectName()]) ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','There are no assets in this room'),
                        'dataProvider' => $activosHardware,
                        'label' => function($model){ 
                        				return  $model->codigo; } ,
                        'value' => function($model){
                        				return  Html::a($model->nombre,
                        						['activo-hardware/view', 'id' => $model->id],
                        						['title'=>Yii::t('app','View Details')]);} ,
                        'format' => 'raw'
                    ]) ?>
                </div>
            </div> 
        </div>
	
	</div>		

</div>
