<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update') . ' ' . $model->nombre;
?>
<div class="activo-infraestructura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
