<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = 'Create Activo Software';
$this->params['breadcrumbs'][] = ['label' => 'Activo Softwares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-software-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
