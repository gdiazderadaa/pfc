<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\Typeahead;
use app\models\Caracteristica;

/* @var $this yii\web\View */
/* @var $model app\models\Caracteristica */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'caracteristica-form']); ?>
<div class="row">
    <div class="col-md-6">
		<div class="caracteristica-form box box-epi-green">

			<div class="box-header">
                <h2 class="box-title"><?= Yii::t('app','Details') ?></h2>
            </div>
            <div class="box-body">
                
                <?= $form->field($model, 'nombre')->widget(Typeahead::classname(),[
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => yii\helpers\Url::to(['/caracteristica/nombres']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>
                
                <?= $form->field($model, 'unidades')->widget(Typeahead::classname(),[
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => yii\helpers\Url::to(['/caracteristica/unidades']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>


    			<?= $form->field($model, 'tipo_activo')->widget(Select2::classname(), [
                    'theme' => Select2::THEME_DEFAULT,
                    'data' => [ 'infraestructura' => 'Infraestructura', 'hardware' => 'Hardware', 'software' => 'Software', 'modelo componente' => 'Modelo Componente', ],
                    'options' => [
                        'placeholder' => ''
                    ],
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
</div>
<?php ActiveForm::end(); ?>