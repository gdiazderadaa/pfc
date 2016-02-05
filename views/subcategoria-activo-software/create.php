<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SubcategoriaActivoSoftware */

$this->title = Yii::t('app', 'Create {modelClass}', [
		              'modelClass' => 'Software Asset Subcategory',
	   	               ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Software Asset Subcategories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-activo-software-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
