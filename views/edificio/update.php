<?php



/* @var $this yii\web\View */
/* @var $model app\models\Edificio */

$this->title = Yii::t('app', 'Update {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edificio-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
