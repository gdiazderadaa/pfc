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
$this->registerJs('$(document).ready(function(){
                    validatePartes("'.$uniq.'", false);                                
                    });
                    
                    function validatePartes(selectID, stopPropagate){
                        console.log("Validate select id:"+selectID+ ", stopPropagate=" + stopPropagate) 
                        //get selected elements from other selects
                        removeAlreadySelectedParts(selectID);
                         
                        //remove view when there is no parts available
                        removeUnusedView(selectID);
                        
                        removeCurrentSelectedPartFromOthers(selectID);
                        
                        if (!stopPropagate){
                            
                            //Event handler to validate others when changing this
                            $("#"+selectID).on("change",function (){
                                console.log("Change made to #" + selectID);
                                getOtherSelects(selectID).each(function(){
                                    var other = $(this);
                                    console.log("Other select id:"+other.attr("id"));
                                    
                                    validatePartes(other.attr("id"), true);
                                });
                            });
                            
                            //Event handler to append selected option to others when removing this
                             $("#"+selectID).closest("li.list-group-item").find(".remove-dynamic-relation").on("click",function(){

                                var optionValue = $("#"+selectID +" option:selected").val();
                                var optionText = $("#"+selectID +" option:selected").text();
                                                                 
                                 console.log("Removing #" + selectID + ". Value=" + optionValue + " Text=" +optionText);
                                 
                                 getOtherSelects(selectID).each(function(){      
                                    var other = $(this);                                    
                                    other.append("<option value="+optionValue+">"+optionText+"</option>");
                                    console.log("Append option " + optionText + " to select " + other.attr("id"));
                                });
                            });                            
                        }                    
                    }
                    
                    function removeAlreadySelectedParts(selectID){
                        getOtherSelects(selectID).each(function(){
                            console.log("Removing "+$(this).find("option:selected").text()+ " from " + selectID)
                            $("#"+selectID +" option[value="+$(this).find("option:selected").val()+"]").remove();
                        });
                    }
                    
                    function removeUnusedView(selectID){
                        if ( $("#"+selectID +" option").size() == 0){
                            alert("'.Yii::t('app',"No software available").'");
                            setTimeout(function removeView(){
                                            $("#"+selectID).parent().prev(".remove-dynamic-relation").trigger("click");
                            }, 500);                           
                        } 
                    }
                    
                    function removeCurrentSelectedPartFromOthers(selectID){
                        getOtherSelects(selectID).each(function(){
                            console.log("Removing "+$("#"+selectID).find("option:selected").text()+ " from " + $(this)[0].id);
                            $("#"+$(this)[0].id +" option[value="+$("#"+selectID).find("option:selected").val()+"]").remove();
                        });
                    }
                    
                    function getOtherSelects(selectID) {
                        return $("#"+selectID).closest("ul.list-group").find("li.list-group-item  select").not("#"+selectID); 
                    }                 
                    ', \yii\web\VIEW::POS_END,'"'.$uniq.'"');
?>

<div class="ConfiguracionActivoHardware-form form" <?= $removeAttr; ?>>
    <select id="<?= $uniq ?>" name="<?php echo $frag.'[activo_software_id]' ?>" class="form-control">
        <?php
            $activosSoftware = $model->getActivosSoftware();
            foreach ($activosSoftware as $activoSoftware) {
                echo '<option value="'.$activoSoftware->id.'">'.$activoSoftware->nombre.'</option>';
            }
            if (!$model->isNewRecord) echo '<option value="'.$model->activoSoftware->id.'" selected>'.$model->activoSoftware->nombre.'</option>';
        ?>
    </select>  
</div>