<?php
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\ConfiguracionActivoHardware */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['configuracion-activo-hardware/delete', 'id' => $model->id]) . '"';
    $frag = "ConfiguracionActivoHardware[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ConfiguracionActivoHardware[new][$uniq]";
}
?>

<div class="ConfiguracionActivoHardware-form form" <?= $removeAttr; ?> data-message="<?= Yii::t('app','No more software available') ?>">
    <?php
        if ($model->isNewRecord){
    ?>
    		<div class="input-group">
                <span class="input-group-addon bg-gray-light"></span>
	            <select id="<?= $uniq ?>" name="<?php echo $frag.'[activo_software_id]' ?>" class="form-control dynamic-relation-property" >
	                    <?php
	                        foreach ($model->getActivosSoftware() as $category=>$softwares) {?>
	                        	<optgroup label="<?= $category ?>">
	                        		<?php
	                        		foreach ($softwares as $key=>$value){?>
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
                    <span class="input-group-addon bg-gray-light dynamic-relation-property dynamic-relation-optgroup" id="<?= $uniq ?>"><?= $model->activoSoftware->categoria->nombre; ?></span>
                    <input type="hidden" name="<?php echo $frag.'[activo_software_id]'?>" value="<?=$model->activoSoftware->id ?>" />
                    <input class="form-control dynamic-relation-value" type="text"  value="<?php echo $model->activoSoftware->nombre; ?>"/>
                </div>  
            <?php  
        }
    ?> 
</div>