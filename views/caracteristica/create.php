<?php




/* @var $this yii\web\View */
/* @var $model app\models\Caracteristica */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => $model::singularObjectName()]);
$this->params['breadcrumbs'][] = ['label' => $model::pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caracteristica-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
