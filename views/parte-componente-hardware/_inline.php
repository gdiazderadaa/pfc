<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\ParteComponenteHardware */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['parte-componente-hardware/delete', 'id' => $model->id]) . '"';
    $frag = "ParteComponenteHardware[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ParteComponenteHardware[new][$uniq]";
}
?>

<div class="ParteComponenteHardware-form form" <?= $removeAttr; ?> data-message="<?= Yii::t('app','No more components availables') ?>">
	<?php
        if ($model->isNewRecord){
    ?>
    		<div class="input-group">
                <span class="input-group-addon bg-gray-light"></span>
	            <select id="<?= $uniq ?>" name="<?php echo $frag.'[parte_componente_hardware_id]' ?>" class="form-control  dynamic-relation-property" >
	                    <?php
	                        foreach ($model->getFreePartesComponenteHardware($params['parent_id']) as $category=>$components) {?>
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
                    <span class="input-group-addon bg-gray-light dynamic-relation-property dynamic-relation-optgroup" id="<?= $uniq ?>"><?= $model->parteComponenteHardware->modeloComponenteHardware->categoria->nombre; ?></span>
                    <input type="hidden" name="<?php echo $frag.'[parte_componente_hardware_id]'?>" value="<?=$model->parteComponenteHardware->id ?>" />
                    <input class="form-control dynamic-relation-value" type="text"  value="<?php echo $model->parteComponenteHardware->modeloComponenteHardware->modelo; if($model->parteComponenteHardware->modeloComponenteHardware->inventario) echo " (".$model->parteComponenteHardware->numero_serie.")" ; ?>"/>
                </div>  
            <?php  
        }
    ?>  

 
</div>