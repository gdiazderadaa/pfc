<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = Yii::t('app', 'Create {modelClass}', [
                     'modelClass' => 'Software Asset',
                     ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-software-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
