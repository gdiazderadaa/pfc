<?php

use app\common\widgets\KeyValueListView;

$this->title = $model->nombre;
?>
<div class="box box-epi-blue">
	<div class="box-header with-border">
    	<h5 class="box-title"><?= Yii::t('app', 'Features') ?></h5>
    </div>
    <div class="box-body table-responsive no-padding">
		<div class="modelo-componente-hardware-view-caracteristicas">
		    <?= KeyValueListView::widget([
		        'options' =>[
		            'class' => 'table table-hover details'
		        ],
		        'dataProvider' => $dataProvider,
		        'label' => 'caracteristica.nombre',
		        'value' => 'valor',      
		    ]) ?>
		</div>
	</div>
</div>