<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoHardware */

$this->title = Yii::t('app', '{modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-hardware-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->activo_inventariable_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->activo_inventariable_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'nombre',
            [
                'label' => $model->attributeLabels()['subcategoria_activo_hardware_id'],
                'value' => $model->subcategoriaActivoHardware->nombre
            ],
            [
                'label' => $model->parent->attributeLabels()['fecha_compra'],
                'value' => Yii::$app->formatter->asDate($model->fecha_compra)
            ],
            [
                'label' => $model->parent->attributeLabels()['precio_compra'], 
                'value' => Yii::$app->formatter->asCurrency($model->precio_compra)
            ],
            [
                'label' => $model->parent->attributeLabels()['espacio_id'],
                'value' => $model->espacio ? $model->espacio->nombre : ""
            ],
        ],
    ]) ?>

<?php
        
        $configuraciones = $model->getConfiguracionesActivoHardware()->all();
        
        if(count($configuraciones)>0) 
            echo "<h2>" . $configuraciones[0]->pluralObjectName() . "</h2>";
        
        foreach ($configuraciones as $variable) {      
    ?>
    
        <?= DetailView::widget([
            'model' => $variable,
            'attributes' => [
                [
                    'label' => $variable->activoSoftware->subcategoriaActivoSoftware->nombre,
                    'value' => $variable->activoSoftware->nombre
                ],       
            ],
        ]) ?>
    
    <?php
        }
                                                    
    ?>

</div>
