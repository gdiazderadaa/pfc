<?php



/* @var $this yii\web\View */
/* @var $model app\models\ActivoHardware */

$this->title = Yii::t('app', 'Clone {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-hardware-clone">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>