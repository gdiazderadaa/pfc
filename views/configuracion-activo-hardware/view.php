<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ConfiguracionActivoHardware */

$this->title = Yii::t('app', '{modelClass}:', [
		               'modelClass' => $model->singularObjectName(),
		               ]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracion-activo-hardware-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'activo_hardware_id' => $model->activo_hardware_id, 'activo_software_id' => $model->activo_software_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'activo_hardware_id' => $model->activo_hardware_id, 'activo_software_id' => $model->activo_software_id], [
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
            'activo_hardware_id',
            'activo_software_id',
        ],
    ]) ?>

</div>
