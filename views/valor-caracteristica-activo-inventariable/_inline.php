<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaractActivoInventariable */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['valor-caracteristica-activo-inventariable/delete', 'id' => $model->id]) . '"';
    $frag = "ValorCaracteristicaActivoInventariable[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ValorCaracteristicaActivoInventariable[new][$uniq]";
}
?>

<div class="ValorCaracteristicaActivoInventariable-form form" <?= $removeAttr;  ?> data-message="<?= Yii::t('app','No more features availables') ?>">
    <?php
        if ($model->isNewRecord){
    ?>
    		<div class="input-group">
                <span class="input-group-addon bg-gray-light"></span>
	            <select id="<?= $uniq ?>" name="<?php echo $frag.'[caracteristica_id]' ?>" class="form-control  dynamic-relation-property" >
	                    <?php
	                        foreach ($model->getCaracteristicasByTipoActivo($params['tipo_activo']) as $caracteristica) {?>
	                                <option value="<?= $caracteristica->id ?>"><?php echo $caracteristica->nombre; if($caracteristica->unidades)  echo  ' (' . $caracteristica->unidades . ')';  ?></option>
	                        <?php }
	                    ?>
	            </select>
	            <input type="text" name="<?php echo $frag.'[valor]' ?>" class="form-control" />
    		</div>
    <?php        
        }
        else{
                ?>
                <div class="input-group">
                    <span class="input-group-addon bg-gray-light dynamic-relation-property" id="<?= $uniq ?>"><?php echo $model->caracteristica->nombre; if($model->caracteristica->unidades)  echo  ' (' . $model->caracteristica->unidades . ')'; ?></span>
                    <input type="hidden" value="<?=$model->caracteristica->id ?>" />
                    <input class="form-control dynamic-relation-value" type="text" name="<?php echo $frag.'[valor]' ?>" value="<?php echo $model->valor ?>"/>
                </div>  
            <?php  
        }
    ?>    
</div>