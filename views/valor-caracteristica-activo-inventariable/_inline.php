<?php
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\DateControl;
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

<div class="ValorCaracteristicaActivoInventariable-form form" <?= $removeAttr;  ?>>
    <?php
        if ($model->isNewRecord){
    ?>
            <select name="<?php echo $frag.'[caracteristica_id]' ?>" class="form-control">
                <?php
                    foreach ($model->getCaracteristicasByTipoActivo($params['tipo_activo']) as $id => $nombre) {
                        echo '<option value="'.$id.'">'.$nombre.'</option>';
                    }
                ?>
            </select>  
            <input type="text" class="form-control" placeholder="Valor" name="<?php echo $frag.'[valor]' ?>" value="" />
    <?php        
        }
        else{
                ?>
                <div class="input-group">
                    <span class="input-group-addon"><?php  echo $model->caracteristica->nombre ?></span>
                    <input class="form-control" type="text" name="<?php echo $frag.'[valor]' ?>" value="<?php echo $model->valor ?>"/>
                </div>  
            <?php  
        }
    ?>    
</div>