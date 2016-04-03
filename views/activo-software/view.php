<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'View') . ' ' . $model->nombre;
?>
<div class="activo-software-view">

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
                'label' => $model->attributeLabels()['subcategoria_activo_software_id'],
                'value' => $model->subcategoriaActivoSoftware->nombre
            ],
            [
                'label' => $model->parent->attributeLabels()['fecha_compra'],
                'value' => Yii::$app->formatter->asDate($model->fecha_compra)
            ],
            [
                'label' => $model->parent->attributeLabels()['precio_compra'], 
                'value' => Yii::$app->formatter->asCurrency($model->precio_compra)
            ],
        ],
    ]) ?>

<?php
        
        $caracteristicas = $model->getValoresCaracteristicasActivoInventariable()->all();
        
        if(count($caracteristicas)>0) 
            echo "<h2>" . Yii::t('app','Features') . "</h2>";
        
        foreach ($caracteristicas as $variable) {      
    ?>
    
        <?= DetailView::widget([
            'model' => $variable,
            'attributes' => [
                [
                    'label' => $variable->caracteristica->nombre,
                    'value' => $variable->caracteristica->unidades == null ? $variable->valor : $variable->valor  . ' ' . $variable->caracteristica->unidades
                ],       
            ],
        ]) ?>
    
    <?php
        }
                                                    
    ?>

</div>





