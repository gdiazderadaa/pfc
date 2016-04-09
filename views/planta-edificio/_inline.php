<?php
use synatree\dynamicrelations\DynamicRelations;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\PlantaEdificio */


// generate something globally unique.
$uniq = uniqid();

if( $model->primaryKey )
{
    // you must define an attribute called "data-dynamic-relation-remove-route" if you plan to allow inline deletion of models from the form.
    $removeAttr = 'data-dynamic-relation-remove-route="' . 
        Url::toRoute(['planta-edificio/delete', 'id' => $model->id]) . '"';
    $frag = "PlantaEdificio[{$model->primaryKey}]";
    $attr = "[{$model->primaryKey}]";
}
else
{
    $removeAttr = "";
    // new models must go under a key called "[new]"
    $frag = "PlantaEdificio[new][$uniq]";
    $attr = "[new][$uniq]";
}

if( $model->isNewRecord ){
    $this->registerJs('$(document).ready(function(){
                        console.log("Input #'.$uniq.'");
                        $("#'.$uniq.'").fileinput({
                            "fileTypeSettings" :"image",
                            "allowedFileExtensions": ["jpg","gif","png"],
                            "showRemove: "true",
                            "showUpload":"false",
                            "language":"es",                               
                        });
                                          
                });
                    ', \yii\web\VIEW::POS_END,'"'.$uniq.'"');
}


?>

<div class="PlantaEdificio-form form" <?= $removeAttr; ?>>
    
    <input type="text" class="form-control" placeholder="Nombre" name="<?php echo $frag.'[nombre]' ?>" value="<?php echo $model->nombre ?>" />
    
    <?php
    if($model->isNewRecord || !isset($model->imagen) || !isset($model->imagen_servidor)){
        ?>
            <input type="file" id="<?= $uniq ?>"  class="file" name="<?php echo $frag.'[imagen]' ?>" value="" data-show-upload="false" data-language="es" data-file-type-settings="image"/>
        <?php
       
    }else{
        echo FileInput::widget([
                //'type' => 'file',
                'name' => $frag.'[imagen]',
                //'value' => $model->imagen, 
               //'attribute' => '[imagen]', 
                'options'=>[
                    'accept'=>'image/*',
                ],
                'pluginOptions'=>[
                    'fileTypeSettings' => 'image',
                    'allowedFileExtensions'=>['jpg','gif','png'],
                    'showRemove' => true,
                    'showUpload' => false,
                    'initialPreview'=>[
                        Html::img($model->getImageUrl(), ['class'=>'file-preview-image', 'alt'=>'', 'title'=>'']),
                    ],
                    'initialCaption'=> isset($model->nombre) ? $model->nombre : '',
                ],
                'pluginEvents' => [
                    'fileclear' => 'function() { 
                                        console.log("File clear");
                                        $("#'.$uniq.'-hidden").val("");
                                    }',
                ]
            ]);
    }
    ?>
    <input type="hidden" id="<?php echo $uniq.'-hidden' ?>" name="<?php echo $frag.'[imagen]' ?>" value="<?php echo $model->imagen ?>" />
 
</div>