<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivoInventariable */

$this->title = Yii::t('app', 'Create {modelClass}', [
                      'modelClass' => $model->singularObjectName(),
                       ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $model->pluralObjectName()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-inventariable-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
