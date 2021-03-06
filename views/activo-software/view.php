<?php

use app\common\widgets\KeyValueListView;
use kartik\dropdown\DropdownX;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-software-view">

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
                            ['label' => Yii::t('app', 'Clone'), 'url' => ['clone', 'id' => $model->id]],
                        ],
                    ]);
                ?>
            </div>
        </div>
    </div>
    
<!--     <div class="row"> -->
<!--        <div class="col-sm-2 pull-right"> -->
<!--             <div class=" info-box-sm"> -->
<!--                 <span class="info-box-icon bg-epi-orange"> -->
<!--                     <i class="fa fa-cubes"></i> -->
<!--                 </span> -->

<!--                 <div class="info-box-content"> -->
<!--                     <span class="info-box-text"></span> -->
<!--                     <span class="info-box-number info-box-number-sm"></span> -->
<!--                 </div> -->
<!--             </div> -->
<!--         </div> -->
        
<!--         <div class="col-sm-2 pull-right"> -->
<!--             <div class="info-box-sm"> -->
<!--                 <span class="info-box-icon bg-epi-red"> -->
<!--                     <i class="fa fa-money"></i> -->
<!--                 </span> -->

<!--                 <div class="info-box-content"> -->
<!--                     <span class="info-box-text"></span> -->
<!--                     <span class="info-box-number"></span> -->
<!--                 </div> -->
<!--             </div> -->
<!--         </div> -->
        
<!--         <div class="col-sm-2 pull-right"> -->
<!--             <div class="info-box-sm"> -->
<!--                 <span class="info-box-icon bg-epi-brown"> -->
<!--                     <i class="fa fa-calendar"></i> -->
<!--                 </span> -->

<!--                 <div class="info-box-content"> -->
<!--                     <span class="info-box-text"></span> -->
<!--                     <span class="info-box-number"></span> -->
<!--                 </div> -->
<!--             </div> -->
<!--         </div> -->
<!--     </div> -->

   

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
				        ],
				    ]) ?>
                </div>
            </div>
        </div>
            
        <div class="col-lg-4">
            <div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= app\models\Caracteristica::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                        'dataProvider' => $caracteristicas,
                    	'emptyText' => Yii::t('app','This {modelClass} has no {features} yet',[
                    						'modelClass' => $model->singularObjectName(),
                    						'features' => app\models\Caracteristica::pluralObjectName()
                    					]),
                        'label' => function($model){ 
                        				return  $model->caracteristica->unidades != null ? 
                        						$model->caracteristica->nombre.'('.$model->caracteristica->unidades.')' 
												: $model->caracteristica->nombre; } ,
                        'value' => 'valor',      
                    ]) ?>
                </div>
            </div>            
        </div>
        
        <div class="col-lg-4">
            <div class="box box-epi-gold">
                <div class="box-header">
                    <h3 class="box-title"><?= Yii::t('app','Installed in...') ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                    	'emptyText' => Yii::t('app','This {modelClass} has not been installed in any {features} yet',[
                    						'modelClass' => $model->singularObjectName(),
                    						'features' => app\models\ActivoHardware::singularObjectName()
                    					]),
                        'dataProvider' => $hardware,
                        'label' => 'codigo',
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





