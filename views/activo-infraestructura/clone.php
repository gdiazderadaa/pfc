<?php



/* @var $this yii\web\View */
/* @var $model app\models\ActivoSoftware */

$this->title = Yii::t('app', 'Clone {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activo-infraestructura-clone">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>