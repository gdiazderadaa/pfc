<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title =Yii::$app->name .' - '. Yii::t('app','Sign In');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <img alt="Epi Gijón logo" src="<?= yii\helpers\Url::to('@web/images/epi-logo.png') ?>" />
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <!--<?= Yii::t('app','Enter your user and password') ?>-->
        <h1 class="login-box-msg title"><?= Yii::$app->name ?></h1>
        <h2 class="login-box-msg small"><?= Yii::t('app','Asset & Incident Management') ?></h2>      	

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-epi-green btn-block', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <div class="login-box-footer">
    	<p class="small text-muted text-center">El usuario y la contrase&ntilde;a para autenticarse son los utilizados para el correo electr&oacute;nico de UniOvi</p>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
