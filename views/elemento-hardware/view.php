<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ElementoHardware */

$this->title = Yii::t('app', '{modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->marca . ' ' . $model->modelo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="elemento-hardware-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'numero_serie',
            'marca',
            'modelo',
            [
                'label' => $model->attributeLabels()['subcategoria_elemento_hardware_id'], 
                'value' => $model->subcategoriaElementoHardware->nombre
            ],
            [
                'label' => $model->attributeLabels()['fecha_compra'], 
                'value' => Yii::$app->formatter->asDate($model->fecha_compra)
            ],
            [
                'label' => $model->attributeLabels()['precio_compra'], 
                'value' => Yii::$app->formatter->asCurrency($model->precio_compra)
                ],
            [
                'label' => $model->attributeLabels()['activo_hardware_id'], 
                'value' => $model->activoHardware ? $model->activoHardware->nombre : ""
            ],
        ],
    ]) ?>

<?php
        
        $caracteristicas = $model->valoresCaracteristicasElementoHardware;
        
        if(count($caracteristicas)>0) 
            echo "<h2>" . $caracteristicas[0]->pluralObjectName() ."</h2>";
        
        foreach ($caracteristicas as $variable) {      
    ?>
    
        <?= DetailView::widget([
            'model' => $variable,
            'attributes' => [
                [
                    'label' => $variable->caracteristica->nombre,
                    'value'=> $variable->caracteristica->unidades == null ? 
                                $variable->valor : 
                                $variable->valor  . ' ' . $variable->caracteristica->unidades
                ],       
            ],
        ]) ?>
    
    <?php
        }
        
         $partes = $model->partesElementoHardware;
        
        if(count($partes)>0) 
            echo "<h2>" . $partes[0]->pluralObjectName() ."</h2>";
        
        foreach ($partes as $variable) {      
    ?>
    
        <?= DetailView::widget([
        'model' => $variable,
        'attributes' => [
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['numero_serie'],
                'value' => $variable->parteElementoHardware->numero_serie
            ],
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['marca'],
                'value' => $variable->parteElementoHardware->marca
            ],
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['modelo'],
                'value' => $variable->parteElementoHardware->modelo],
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['subcategoria_elemento_hardware_id'], 
                'value' => $variable->parteElementoHardware->subcategoriaElementoHardware->nombre
            ],
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['fecha_compra'],
                'value'=> Yii::$app->formatter->asDate($variable->parteElementoHardware->fecha_compra)
            ],
            [
                'label' => $variable->parteElementoHardware->attributeLabels()['precio_compra'], 
                'value' => Yii::$app->formatter->asCurrency($variable->parteElementoHardware->precio_compra)
            ],
        ],
    ]) ?>
    
    <?php
        }                                                   
    ?>

</div>




