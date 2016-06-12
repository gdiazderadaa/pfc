<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\ActiveField;
use synatree\dynamicrelations\DynamicRelations;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
use kartik\widgets\Typeahead;


/* @var $this yii\web\View */
/* @var $model app\models\ModeloComponenteHardware */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="alert alert-info-white alert-dismissible <?= !$model->isNewRecord ? 'hidden' : ''; ?>" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-question"></i><?= Yii::t('app','How to')?></h4>
    <ul>
    	<li><?= Yii::t('app','Enter the Manufacturer, Model and Category of the Hardware Component Model.') ?></li>
    	<li><?= Yii::t('app','Turn on the inventory if you plan to keep track of every single Hardware Component created from this Hardware Component Model. With this feature on, the serial numbers of the Hardware Components will be used to identify them. ') ?></li>
    	<li><?= Yii::t('app','Add as much features as you want on the Features panel') ?></li>
    	<li><?= Yii::t('app','To finish, click on the "Create" button') ?></li>
    </ul> 
</div>

<div class="alert alert-warning alert-dismissible <?= $model->componentesHardware == null ? 'hidden' : ''; ?>" >
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p><i class="icon fa fa-warning"></i><?= Yii::t('app','The inventory cannot be enabled because there are {modelClass} linked to the model', [
                                'modelClass' => \app\models\ComponenteHardware::pluralObjectName()
                                ]) ?>
</div>

<?php $form = ActiveForm::begin(['id' => 'modelo-componente-hardware-form']); ?>
<div class="row">
    <div class="col-md-6">
        <div class="modelo-componente-hardware-form box box-epi-green">
 
            <div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">
                
                <?= $form->field($model, 'marca')->widget(Typeahead::classname(),[
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => yii\helpers\Url::to(['/modelo-componente-hardware/marcas']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>

                <?= $form->field($model, 'modelo')->widget(Typeahead::classname(),[
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => yii\helpers\Url::to(['/modelo-componente-hardware/modelos']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>

                <?= $form->field($model, 'categoria_id')->widget(Select2::classname(), [
                    'theme' => Select2::THEME_DEFAULT,
                    'data' => $model->categorias,
                    'options' => [
                        'placeholder' => '',
                    ],
                ]) ?>

                <!--<?= $form->field($model, 'cantidad')->textInput(['maxlength' => true]) ?>-->
                
                <?= $form->field($model, 'inventario')->widget(SwitchInput::classname(), [
                        'pluginOptions' => [
                            'onText' => Yii::t('app','Yes'),
                            'offText' => Yii::t('app','No'),
                        ],
                        'disabled' => $model->componentesHardware != null,
                ]) ?>
            </div>
               
            <div class="box-footer">
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-epi-green btn-flat']) ?>
                    <?= Html::a(Yii::t('app', 'Cancel'),Yii::$app->request->referrer , ['class' => 'btn btn-default btn-flat']) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <?= DynamicRelations::widget([
            'boxClass' => 'epi-blue',
            'header' => 'h3',
            'title' => Yii::t('app','Features'),
            'collection' => $model->valoresCaracteristicasModeloComponenteHardware,
            'viewPath' => '@app/views/valor-caracteristica-modelo-componente-hardware/_inline.php',
            'params' => [
                'tipo_activo' => $model->tipo,
                
            ],
            
            // this next line is only needed if there is a chance that the collection above will be empty.  This gives the script a prototype to work with.
            'collectionType' => new app\models\ValorCaracteristicaModeloComponenteHardware,

        ]); ?>    
    </div>
       
</div>
<?php ActiveForm::end(); ?>