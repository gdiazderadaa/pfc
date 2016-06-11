<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\dropdown\DropdownX;
use app\common\widgets\KeyValueListView;

/* @var $this yii\web\View */
/* @var $model app\models\ComponenteHardware */


$js = <<<JS

        // obtener la id del formulario y establecer el manejador de eventos
        $("form#attach-form, form#attach-child-form").on("submit", function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var form = $(this);
            $.post(
                form.attr("action")+"&submit=true",
                form.serialize()
            )
            .done(function(result) {
                // alert(result.message);
                // $('#modal').modal('hide')
                //     .find('#modalContent').html('');
                // $.pjax.reload({container:"#componente-hardware-view"});
            });
            return false;
        });
JS;
$this->registerJs($js);

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="componente-hardware-view" class="componente-hardware-view">

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
	                		'<li class="divider"></li>',
		                    ['label' => Yii::t('app', 'Clone'), 'url' => ['clone', 'id' => $model->id]],
	                		'<li class="divider"></li>',
		                    ['label' => Yii::t('app', 'Assign to an asset'), 
		                        'url'=> ['assign', 'id' => $model->id],
		                        'linkOptions' => ['id' => 'assign', 'class' => 'show-modal', 'title' => Yii::t('app','Select the asset you want to assign this part to')]],
		                    ['label' => Yii::t('app', 'Attach to another part'), 
		                        'url'=> ['parte-componente-hardware/attach', 'id' => $model->id],
		                        'linkOptions' => ['id' => 'attach','data-submit' => Yii::t('app','Attach') , 'class' => 'show-modal', 'title' => Yii::t('app','Select the part you want to attach this part to')]],
		                    ['label' => Yii::t('app', 'Attach child part'), 
		                        'url'=> ['parte-componente-hardware/attach-child', 'id' => $model->id],
		                        'linkOptions' => ['id' => 'attach-child','data-submit' => Yii::t('app','Attach'), 'class' => 'show-modal', 'title' => Yii::t('app','Select the part you want to attach to this part')]],
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
                    <i class="fa fa-question"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Status') ?></span>
                    <span class="info-box-number info-box-number-sm"><?= $model->estado ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-red">
                    <i class="fa fa-money"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Purchase price') ?></span>
                    <span class="info-box-number"><?= Yii::$app->formatter->asCurrency($model->precio_compra) ?></span>
                </div>
            </div>
        </div>
        
        <div class="col-sm-2 pull-right">
            <div class="info-box-sm">
                <span class="info-box-icon bg-epi-brown">
                    <i class="fa fa-calendar"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Yii::t('app','Warranty') ?></span>
                    <span class="info-box-text"><?= $model->textoGarantia ?></span>
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
				            'marcaModeloComponenteHardware',
				            [
				                'attribute' => 'modeloModeloComponenteHardware',
				                'value' => Html::a($model->modeloModeloComponenteHardware,  
				                        ['modelo-componente-hardware/view', 'id' => $model->modelo_componente_hardware_id], 
				                        ['title'=>Yii::t('app','View Details')]),
				                'format' => 'raw'
				            ],
				            'numero_serie',
				            'estado',       
				            'fecha_compra:date',
				            'meses_garantia',
				            'fechaFinGarantia:date',
				            'precio_compra:currency',
				            [
				                'attribute' => 'activo_hardware_id',
				                'value' => $model->activoHardware != null ?
				                                Html::a($model->activoHardware->nombre,  
				                                        ['activo-hardware/view', 'id' => $model->activo_hardware_id], 
				                                        ['title'=>Yii::t('app','View Details')]):
				                                null,
				                'format' => 'raw'
				            ],  
				        ],
				    ]) ?>
                </div>
            </div>
        </div>
            
        <div class="col-md-6">
            <div class="box box-epi-blue">
                <div class="box-header">
                    <h3 class="box-title"><?= \app\models\ParteComponenteHardware::pluralObjectName() ?></h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
                        'dataProvider' => $dataProvider,
                        'label' => function($model){ 
                        				return  $model->parteComponenteHardware->modeloComponenteHardware->categoria->nombre; },
                        'value' => function($model){ 
                        				return  Html::a($model->parteComponenteHardware->numero_serie != null ?
                        					 $model->parteComponenteHardware->modeloComponenteHardware->nombre . ' ('.$model->parteComponenteHardware->numero_serie.')'
                        					 : $model->parteComponenteHardware->modeloComponenteHardware->nombre,  
				                                        ['componente-hardware/view', 'id' => $model->parteComponenteHardware->id], 
				                                        ['title'=>Yii::t('app','View Details')]);} ,
                        'format' => 'raw',     
                    ]) ?>
                </div>
            </div>            
        </div>
                 
    </div>

</div>

