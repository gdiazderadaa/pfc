<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Espacio */

$this->title = Yii::t('app', 'Create {modelClass}', [
		   'modelClass' => 'space',
		]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Spaces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espacio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
