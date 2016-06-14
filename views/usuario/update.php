<?php



/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = Yii::t('app', 'Update {modelClass}', ['modelClass' => $model->login]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
