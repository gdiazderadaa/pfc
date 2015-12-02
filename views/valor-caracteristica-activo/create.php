<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivo */

$this->title = 'Create Valor Caracteristica Activo';
$this->params['breadcrumbs'][] = ['label' => 'Valor Caracteristica Activos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
