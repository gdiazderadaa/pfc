<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PlantaEdificio */

$this->title = Yii::t('app', 'View {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planta-edificio-view">

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
            'nombre',
            'imagen',
            [
                'label' => $model->attributeLabels()['edificio_id'],
                'value' => $model->edificio->nombre
            ],
        ],
    ]) ?>
    
    <?php
    $title = isset($model->ruta_imagen) && !empty($model->ruta_imagen) ? $model->ruta_imagen : Yii::t('app','Image');
    echo Html::img($model->getImageUrl(), [
        'class'=>'img-thumbnail', 
        'alt'=>$title, 
        'title'=>$title
    ]);
    ?>

</div>
