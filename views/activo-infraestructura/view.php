<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use models\ValorCaracteristicaActivo;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = 'Activo ' . $model->Codigo;
$this->params['breadcrumbs'][] = ['label' => 'Activos Infraestructura', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ActivoInventariableID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ActivoInventariableID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Codigo',
            'Nombre',
            ['label' => 'Subcategoria','value'=> $model->subcategoria->Nombre],
            ['label' => 'Fecha de compra','value'=> Yii::$app->formatter->asDate($model->FechaCompra,'dd/MM/yy')],
            ['label' => 'Precio de Compra', 'value' => Yii::$app->formatter->asCurrency($model->PrecioCompra,'EUR')]          
        ],
    ]) ?>
    
    <h2>Caracteristicas</h2>

    <?php
        
        $caracteristicas = $model->getValorCaracteristicaActivos()->all();
        
        foreach ($caracteristicas as $variable) {      
    ?>
    
        <?= DetailView::widget([
            'model' => $variable,
            'attributes' => [
                ['label' => $variable->caracteristica->Nombre,'value'=> $variable->caracteristica->Unidades == null ? $variable->Valor : $variable->Valor  . ' ' . $variable->caracteristica->Unidades],       
            ],
        ]) ?>
    
    <?php
        }
                                                    
    ?>

</div>
