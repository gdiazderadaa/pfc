<?php
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivo */
/* @var $activo app\models\ValorCaractActivoInventariable */
/* @var $form kartik\widgets\ActiveForm */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['valor-caracteristica-activo/delete', 'id' => $model->ValorCaracteristicaActivoID]) . '"';
    $frag = "ValorCaracteristicaActivo[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ValorCaracteristicaActivo[new][$uniq]";
}

?>

<div class="ValorCaracteristicaActivo-form form" <?= $removeAttr; ?>>
    <?php
        if ($model->isNewRecord){
    ?>
            <select name="<?php echo $frag.'[CaracteristicaID]' ?>" class="form-control">
                <?php
                    foreach ($model->getCaracteristicas() as $id => $nombre) {
                        echo '<option value="'.$id.'">'.$nombre.'</option>';
                    }
                ?>
            </select>  
            <input type="text" class="form-control" placeholder="Valor" name="<?php echo $frag.'[Valor]' ?>" value="" />
    <?php        
        }
        else{
                ?>
                <div class="input-group">
                    <span class="input-group-addon"><?php  echo $model->caracteristica->Nombre ?></span>
                    <input class="form-control" type="text" name="<?php echo $frag.'[Valor]' ?>" value="<?php echo $model->Valor ?>"/>
                </div>  
            <?php  
        }
    ?>    
</div>