<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Edificio */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'View') . ' ' . $model->nombre;
?>
<div class="edificio-view">

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
    <?php $title = isset($model->ruta_imagen) && !empty($model->ruta_imagen) ? $model->ruta_imagen : Yii::t('app','Image'); ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre:ntext',
            'localidad:ntext',
            [
                'attribute' => $model->attributeLabels()['imagen'],
                'format' => ['image',[
                                'class'=>'img-thumbnail', 
                                'width'=>'33%',
                                'alt'=>$title, 
                                'title'=>$title,]],
                'value' => $model->getImageUrl(),
            ],
        ],
    ]) ?>
    
    <?php

    
    $plantas = $model->plantasEdificio;
        
        if(count($plantas)>0) 
            echo "<h2>" . Yii::t('app','Floors') ."</h2>";
        
        foreach ($plantas as $variable) { 
    ?>
    
    <?= DetailView::widget([
        'model' => $variable,
        'attributes' => [
            [
                'label' => $variable->attributeLabels()['nombre'],
                'value' => $variable->nombre
            ],
            [
                'attribute' => $variable->attributeLabels()['imagen'],
                'format' => ['image',['class'=>'img-thumbnail', 'width'=>'33%']],
                'value' => $variable->getImageUrl(),
            ],
        ],
    ]) ?>
    
    <?php
        }                                                   
    ?>

</div>
