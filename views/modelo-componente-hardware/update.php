<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModeloComponenteHardware */

$this->title = Yii::t('app', 'Update {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-componente-hardware-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
