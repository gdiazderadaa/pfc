<?php



/* @var $this yii\web\View */
/* @var $model app\models\Caracteristica */

$this->title = Yii::t('app', 'Update {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caracteristica-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
