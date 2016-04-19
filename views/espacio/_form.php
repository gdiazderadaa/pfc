<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use app\models\Edificio;
use app\models\PlantaEdificio;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="espacio-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numeracion')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label class="control-label"><?=Edificio::singularObjectName()?></label>
        <?php echo Select2::widget([
                                'options'=>[
                                    'id'=>'edificio-id',
                                    'placeholder' => Yii::t('app', '- Select the {modelClass} -', [
                                        'modelClass' => PlantaEdificio::attributeLabels()['edificio_id'],
                                        ]),
                                ],
                                'name' => 'edificio',
                                'data' => $model->getEdificioList(),
                                'value' => $model->isNewRecord ? '' : $model->plantaEdificio->edificio_id
                            ]); ?>
    </div>                    
    
    <?= $form->field($model, 'planta_edificio_id')->widget(DepDrop::classname(), [
        'type' => DepDrop::TYPE_SELECT2,
        'data' => $model->isNewRecord ? [] : [$model->planta_edificio_id => $model->plantaEdificio->nombre],
        'pluginOptions'=>[
            'initialize' => $model->isNewRecord ? false : true,
            'depends'=>['edificio-id'],
            'placeholder'=> Yii::t('app', '- Select the {modelClass} -', [
		               'modelClass' => $model->attributeLabels()['planta_edificio_id'],
		              ]),
            'url'=>Url::to(['/planta-edificio/planta'])
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
