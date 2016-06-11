<?php




/* @var $this yii\web\View */
/* @var $model app\models\Edificio */

$this->title = Yii::t('app', 'Create {modelClass}', ['modelClass' => $model::singularObjectName()]);
$this->params['breadcrumbs'][] = ['label' => $model::pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edificio-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
