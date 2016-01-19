<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoSoftware */

$this->title = 'Update Subcategoria Activo Software: ' . ' ' . $model->SubcategoriaActivoSoftwareID;
$this->params['breadcrumbs'][] = ['label' => 'Subcategoria Activo Softwares', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubcategoriaActivoSoftwareID, 'url' => ['view', 'id' => $model->SubcategoriaActivoSoftwareID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcategoria-activo-software-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
