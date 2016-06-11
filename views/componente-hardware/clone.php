<?php



/* @var $this yii\web\View */
/* @var $model app\models\ComponenteHardware */
                
$this->title = Yii::t('app', 'Clone {modelClass}', ['modelClass' => $model->nombre]);
$this->params['breadcrumbs'][] = ['label' =>  $model->pluralObjectName(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="componente-hardware-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
