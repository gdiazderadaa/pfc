<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use kartik\widgets\Typeahead;
use app\models\Edificio;
use app\models\PlantaEdificio;

/* @var $this yii\web\View */
/* @var $model app\models\Espacio */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'espacio-form']); ?>
<div class="row">
    <div class="col-md-6">
		<div class="espacio-form box box-epi-green">
 
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
                                'url' => yii\helpers\Url::to(['/espacio/nombres']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>
                
            	<?= $form->field($model, 'numeracion')->widget(Typeahead::classname(),[
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => yii\helpers\Url::to(['/espacio/numeraciones']) . '?q=%QUERY',
                                'wildcard' => '%QUERY',
                            ]
                        ]
                    ]
                ]) ?>


			    <div class="form-group">
			        <label class="control-label"><?=Edificio::singularObjectName()?></label>
			        <?php echo Select2::widget([
			        			'theme' => Select2::THEME_DEFAULT,
                                'options'=>[
                                    'id'=>'edificio-id',
                                    'placeholder' => '',
                                ],
                                'name' => 'edificio',
                                'data' => Edificio::getEdificios(),
                                'value' => $model->isNewRecord ? '' : $model->plantaEdificio->edificio_id
                            ]); ?>
	    		</div>                    
	    
			    <?= $form->field($model, 'planta_edificio_id')->widget(DepDrop::classname(), [
			        'type' => DepDrop::TYPE_SELECT2,
			        'data' => $model->isNewRecord ? [] : [$model->planta_edificio_id => $model->plantaEdificio->nombre],
			        'pluginOptions'=>[
			            'initialize' => $model->isNewRecord ? false : true,
			            'depends'=>['edificio-id'],
			            'placeholder'=> '',
			            'url'=>Url::to(['/planta-edificio/plantas-by-edificio'])
			        ],
		    		'select2Options' => ['theme' => Select2::THEME_DEFAULT]
			    ]); ?>

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