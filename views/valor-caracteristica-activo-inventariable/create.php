<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ValorCaracteristicaActivoInventariable */

$this->title = Yii::t('app', 'Create {modelClass}', [
		              'modelClass' => 'Asset Feature Value',
	   	               ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Asset Features Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="valor-caracteristica-activo-inventariable-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
