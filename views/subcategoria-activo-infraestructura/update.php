<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoInfraestructura */

$this->title = 'Update Subcategoria Activo Infraestructura: ' . ' ' . $model->SubcategoriaActivoInfraestructuraID;
$this->params['breadcrumbs'][] = ['label' => 'Subcategoria Activo Infraestructuras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SubcategoriaActivoInfraestructuraID, 'url' => ['view', 'id' => $model->SubcategoriaActivoInfraestructuraID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcategoria-activo-infraestructura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
