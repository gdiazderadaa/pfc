<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = Yii::t('app', 'Create {modelClass}', [
                      'modelClass' => 'Infrastructure Asset',
                       ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infrastructure Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
