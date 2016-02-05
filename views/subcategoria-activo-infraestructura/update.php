<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoInfraestructura */

$this->title = Yii::t('app', 'Update {modelClass}:', [
                      'modelClass' => 'Infrastructure Asset Subcategory',
                       ]) . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infrastructure Asset Subcategories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subcategoria-activo-infraestructura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
