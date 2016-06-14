<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => $model::singularObjectName()]);
$this->params['breadcrumbs'][] = ['label' => $model::pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
