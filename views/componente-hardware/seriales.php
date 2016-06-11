<div class="componente-hardware-form box box-epi-orange">
	<div class="box-header">
		<h2 class="box-title"><?= Yii::t('app','Serials') ?></h2>
    </div>
    <div class="box-body">
		<?php
		
		for ($i=0; $i < $number ; $i++) {
		    echo yii\helpers\Html::beginTag('div',['class' => 'form-group', 'id' => 'serial-'.$i.'group']); 
		    echo yii\helpers\Html::label('Serial #'.($i+1),'serial-'.$i , ['class' => 'control-label']);
		    echo yii\helpers\Html::Input('text','ComponenteHardware[serial-'.$i.']','',['id' => 'serial-'.$i, 'class' => 'form-control']);
		    echo yii\helpers\Html::beginTag('div',['class' => 'help-block']); 
		    echo yii\helpers\Html::endTag('div'); 
		    echo yii\helpers\Html::endTag('div'); 
		}
		
		?>
	</div>
</div>
