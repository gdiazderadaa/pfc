<?php

use app\common\widgets\KeyValueListView;
use yii\helpers\Html;

$this->title = $model->nombre;
?>
<div class="box box-epi-blue">
	<div class="box-header with-border">
    	<h5 class="box-title"><?= Yii::t('app', 'Floors') ?></h5>
    </div>
    <div class="box-body table-responsive no-padding">
		<div class="edificio-view-plantas">
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
		    <?= KeyValueListView::widget([
                        'options' =>[
                            'class' => 'table table-hover details'
                        ],
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