<?php
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaModeloComponenteHardware */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['valor-caracteristica-modelo-componente-hardware/delete', 'id' => $model->id]) . '"';
    $frag = "ValorCaracteristicaModeloComponenteHardware[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ValorCaracteristicaModeloComponenteHardware[new][$uniq]";
}

$message = Yii::t('app','No features availables');
$js = <<<JS

$(document).ready(function(){                        
    validateFeatures("{$uniq}", false);                           
});
        
function validateFeatures(selectID, stopPropagate){
    console.log("Validate select/span id:"+selectID+ ", stopPropagate=" + stopPropagate); 
    
    if ( $("#"+selectID).is("select") ){
        //get selected elements from other selects and spans
        removeAlreadySelectedFeatures(selectID);
        
        
        //remove view when there is no features available
        removeUnusedView(selectID);
    }                      
    
    removeCurrentSelectedFeatureFromOthers(selectID);
    
    if (!stopPropagate){
        
        //Event handler to validate others when changing this
        $("#"+selectID).on("change",function (){
            console.log("Change made to #" + selectID);
            getOtherSelects(selectID).each(function(){
                var other = $(this);
                console.log("Other select id:"+other.attr("id"));
                
                validateFeatures(other.attr("id"), true);
            });
        });
        
        //Event handler to append selected option to others when removing this
            $("#"+selectID).closest("li.list-group-item").find(".remove-dynamic-relation").on("click",function(){
                
                if ($("#"+selectID).is("select")){
                var optionValue = $("#"+selectID +" option:selected").val();
                var optionText = $("#"+selectID +" option:selected").text();
                }
                else{
                var optionText = $("#"+selectID).text();
                var optionValue = $("#"+selectID).next("input[type=\"hidden\"]").val();
                }
                
                console.log("Removing #" + selectID + ". Value=" + optionValue + " Text=" +optionText);
                
                getOtherSelects(selectID).each(function(){      
                var other = $(this);                                    
                other.append("<option value="+optionValue+">"+optionText+"</option>");
                console.log("Append option " + optionText + " to select " + other.attr("id"));
            });
        });  
        
    }                    
}

function removeAlreadySelectedFeatures(selectID){
    getOtherSelects(selectID).each(function(){
        console.log("Removing "+$(this).find("option:selected").text()+ " from " + selectID);
        $("#"+selectID +" option[value="+$(this).find("option:selected").val()+"]").remove();
    });
    getOtherSpans(selectID).each(function(){
        var optionText = $(this).text();
        
        $("#"+selectID +" option").each(function(){
            if ($(this).text()==optionText){
                console.log("Removing "+optionText+ " from " + selectID);
                $(this).remove();
            }
        });
    });
}

function removeUnusedView(selectID){
    if ( $("#"+selectID +" option").size() == 0){
        alert("{$message}");
        setTimeout(function removeView(){
            $("#"+selectID).parent().parent().prev(".remove-dynamic-relation").trigger("click");
        }, 500);                           
    } 
}

function removeCurrentSelectedFeatureFromOthers(selectID){
    getOtherSelects(selectID).each(function(){
        console.log("Removing "+$("#"+selectID).find("option:selected").text()+ " from " + $(this)[0].id);
        $("#"+$(this)[0].id +" option[value="+$("#"+selectID).find("option:selected").val()+"]").remove();
    });
}

function getOtherSelects(selectID) {
    return $("#"+selectID).closest("ul.list-group").find("li.form-group  select").not("#"+selectID); 
}

function getOtherSpans(selectID) {
    return $("#"+selectID).closest("ul.list-group").find("li.form-group  span").not("#"+selectID); 
}

JS;
 
$this->registerJs($js); 
           
?>

<div class="ValorCaracteristicaModeloComponenteHardware-form form" <?= $removeAttr; ?>>
    <?php
        if ($model->isNewRecord){
    ?>
            <div class="input-group">
                <span class="input-group-addon bg-gray-light"></span>
                 
                <select id="<?= $uniq ?>" name="<?php echo $frag.'[caracteristica_id]' ?>" class="form-control">
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
                    <span class="input-group-addon bg-gray-light" id="<?= $uniq ?>"><?php  echo $model->caracteristica->nombre; if($model->caracteristica->unidades)  echo  ' (' . $model->caracteristica->unidades . ')'; ?></span>
                    <input type="hidden" value="<?=$model->caracteristica->id ?>" />
                    <input class="form-control" type="text" name="<?php echo $frag.'[valor]' ?>" value="<?php echo $model->valor ?>"/>
                </div>  
            <?php  
        }
    ?>    
</div>