<?php

use kartik\dropdown\DropdownX;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-view">

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
				            'nombre',
				            'tipo',
				        ],
    				]) ?>
                </div>
            </div>
        </div>

	</div>
</div>
