<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Informe */

$this->title = 'Create Informe';
$this->params['breadcrumbs'][] = ['label' => 'Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="informe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
