<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ModeloComponenteHardware */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => $model::singularObjectName()]);
$this->params['breadcrumbs'][] = ['label' => $model::pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-componente-hardware-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
