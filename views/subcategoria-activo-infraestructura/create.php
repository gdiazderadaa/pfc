<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoInfraestructura */

$this->title = Yii::t('app', 'Create {modelClass}', [
		              'modelClass' => 'Infrastructure Asset Subcategory',
	   	               ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infrastructure Asset Subcategories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-activo-infraestructura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
