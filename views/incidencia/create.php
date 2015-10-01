<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Incidencia */

$this->title = 'Crear Incidencia';
$this->params['breadcrumbs'][] = ['label' => 'Incidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incidencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
