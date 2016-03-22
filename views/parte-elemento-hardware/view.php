<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ParteElementoHardware */

$this->title = Yii::t('app', '{modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->parteElementoHardware->marca . ' ' . $model->parteElementoHardware->modelo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parte-elemento-hardware-view">

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
            [
                'label' => $model->attributeLabels()['elemento_hardware_id'],
                'value' => $model->elementoHardware->marca . ' ' . $model->elementoHardware->modelo,
            ],
            [
                'label' => $model->attributeLabels()['parte_elemento_hardware_id'],
                'value'=> $model->parteElementoHardware->marca . ' ' . $model->parteElementoHardware->modelo,
            ],
        ],
    ]) ?>

</div>
