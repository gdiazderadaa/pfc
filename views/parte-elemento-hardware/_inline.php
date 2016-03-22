<?php
use synatree\dynamicrelations\DynamicRelations;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\ParteElementoHardware */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['parte-elemento-hardware/delete', 'id' => $model->id]) . '"';
    $frag = "ParteElementoHardware[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "ParteElementoHardware[new][$uniq]";
}
$this->registerJs('$(document).ready(function(){
                    validatePartes("'.$uniq.'", false);                                
                    });
                    
                    function validatePartes(selectID, stopPropagate){
                        console.log("Validate select id:"+selectID+ ", stopPropagate=" + stopPropagate) 
                        //get selected elements from other selects
                        removeAlreadySelectedParts(selectID);
                                             
                        //remove element itself from the fropdown 
                        $("#"+selectID +" option[value=\''.$params['parent_id'].'\']").remove();
                         
                        //remove view when there is no parts available
                        removeUnusedView(selectID);
                        
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
                            alert("'.Yii::t('app',"No parts available").'");
                            setTimeout(function removeView(){
                                            $("#"+selectID).parent().prev(".remove-dynamic-relation").trigger("click");
                            }, 500);                           
                        } 
                    }
                    
                    function getOtherSelects(selectID) {
                        return $("#"+selectID).closest("ul.list-group").find("li.list-group-item  select").not("#"+selectID); 
                    }                 
                    ', \yii\web\VIEW::POS_END,'"'.$uniq.'"');
?>

<div class="ParteElementoHardware-form form" <?= $removeAttr; ?>>
    <select id="<?= $uniq ?>" name="<?php echo $frag.'[parte_elemento_hardware_id]' ?>" class="form-control">
        <?php
            $partes = $model->getFreePartesElementoHardware($params['parent_id']);
            foreach ($partes as $id => $modelo) {
                echo '<option value="'.$id.'">'.$modelo.'</option>';
            }
            if (!$model->isNewRecord) echo '<option value="'.$model->parteElementoHardware->id.'" selected>'.$model->parteElementoHardware->modelo.'</option>';
        ?>
    </select>  
</div>