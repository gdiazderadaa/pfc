<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ActivoInfraestructura */

$this->title = 'Create Activo Infraestructura';
$this->params['breadcrumbs'][] = ['label' => 'Activo Infraestructuras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
