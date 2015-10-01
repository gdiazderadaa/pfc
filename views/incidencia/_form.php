<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\ObjetoSearch;
use yii\bootstrap\Modal;
use kartik\grid\RadioColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Incidencia */
/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel app\models\ObjetoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="incidencia-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion_breve')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

	<?=$form->field($model, 'tipo_id')->dropDownList($model->getTipoList(),['prompt'=>'- Selecciona el tipo de incidencia -']) ?>

    <?= $form->field($model, 'impacto_id')->dropDownList($model->getImpactoList(),['prompt'=>'- Selecciona el impacto de la incidencia -']) ?>

    <?= $form->field($model, 'urgencia_id')->dropDownList($model->getUrgenciaList(),['prompt'=>'- Selecciona la urgencia de la incidencia -']) ?>

    <!--<?= $form->field($model, 'tecnico_id')->textInput() ?>-->

    
    <?= $form->field($model, 'objeto_id')->dropDownList($model->getObjetoList(),['prompt'=>'- Selecciona el objeto relacionado con la incidencia -']) ?>
    
    <div class="form-group">
        <?php Modal::begin([
            'header' => '<h2>Selecciona un objeto</h2>',
            'toggleButton' => [
                'label' => 'Buscar objeto',
                'class' => 'btn btn-primary'
                ],
                'size' => 'modal-lg'
        ]);?> 
    </div>

    <?= GridView::widget([
            'id' => 'objetosGrid',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [ 
                [
                    'class' => '\kartik\grid\RadioColumn',
                    'radioOptions' => function($model, $key, $index, $column) {
                        return ['value' => $model->id];
                    }
                ],
                'codigo',
                'nombre',
                'espacio_id',
                'tipo_id',
            ],
        ]); 
    ?>
    
    <?php Modal::end();
    ?>

    <!--<?= $form->field($model, 'fecha_creacion')->textInput() ?>-->

    <!--<?= $form->field($model, 'fecha_fin')->textInput() ?>-->

    <!--<?= $form->field($model, 'estado_id')->textInput() ?>-->

    <!--<?= $form->field($model, 'creador_id')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs(
    'var $grid = $("#objetosGrid");
     
    $grid.on("grid.radiochecked", function(ev, key, val) {
        $("select#incidencia-objeto_id").val(val);
    });
    
    $grid.on("grid.radiocleared", function(ev, key, val) {
        $("select#incidencia-objeto_id")[0].selectedIndex=0;
    });'
    );
?>
