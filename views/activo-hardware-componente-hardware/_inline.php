<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\ActivoHardwareComponenteHardware */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['activo-hardware-componente-hardware/delete', 'id' => $model->id]) . '"';
    $frag = "ActivoHardwareComponenteHardware[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ActivoHardwareComponenteHardware[new][$uniq]";
}
?>

<div class="ActivoHardwareComponenteHardware form" <?= $removeAttr; ?> data-message="<?= Yii::t('app','No more components availables') ?>">
	<?php
        if ($model->isNewRecord){
    ?>
    		<div class="input-group">
                <span class="input-group-addon bg-gray-light"></span>
	            <select id="<?= $uniq ?>" name="<?php echo $frag.'[componente_hardware_id]' ?>" class="form-control dynamic-relation-property" >
	                    <?php
	                        foreach ($model->getFreeComponentesHardware($params['parent_id']) as $category=>$components) {?>
	                        	<optgroup label="<?= $category ?>">
	                        		<?php
	                        		foreach ($components as $key=>$value){?>
	                        			<option value="<?= $key ?>" data-optgroup="<?= $category ?>"><?php echo $value;  ?></option>
	                        		<?php } ?>
	                        		</optgroup>
	                                
	                        <?php }
	                    ?>
	            </select>
    		</div>
    <?php        
        }
        else{
                ?>
                <div class="input-group">
                    <span class="input-group-addon bg-gray-light dynamic-relation-property dynamic-relation-optgroup" id="<?= $uniq ?>"><?= $model->componenteHardware->modeloComponenteHardware->categoria->nombre; ?></span>
                    <input type="hidden" name="<?php echo $frag.'[componente_hardware_id]'?>" value="<?=$model->componenteHardware->id ?>" />
                    <input class="form-control dynamic-relation-value" type="text"  value="<?php echo $model->componenteHardware->modeloComponenteHardware->modelo; if($model->componenteHardware->modeloComponenteHardware->inventario) echo " (".$model->componenteHardware->numero_serie.")" ; ?>"/>
                </div>  
            <?php  
        }
    ?>  

 
</div>