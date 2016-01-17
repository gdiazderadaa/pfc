<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoInfraestructura */

$this->title = 'Create Subcategoria Activo Infraestructura';
$this->params['breadcrumbs'][] = ['label' => 'Subcategoria Activo Infraestructuras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-activo-infraestructura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>