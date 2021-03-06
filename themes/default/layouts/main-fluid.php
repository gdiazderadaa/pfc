<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'SGAI-Sistema de Gestión de Activos e Incidencias',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $navItems=[
                ['label' => 'Home', 'url' => ['/site/index']],
					[
                       'label' => 'Incidencias',
                       'items' => [
                            ['label' => 'Crear', 'url' => ['/incidencia/create']],
                            ['label' => 'Consultar', 'url' => ['/incidencia/index']],
                        ],
                    ],
                    [
                       'label' => 'Activos',
                       'items' => [
                            ['label' => 'Crear', 'url' => ['/objeto/create']],
                            ['label' => 'Consultar', 'url' => ['/objeto/index']],
                        ],
                    ],
                    [
                       'label' => 'Informes',
                       'items' => [
                            ['label' => 'Crear', 'url' => ['/informe/create']],
                            ['label' => 'Consultar', 'url' => ['/informe/index']],
                        ],
                    ],
					  [
                       'label' => 'Edificios',
                       'items' => [
                            ['label' => 'Crear', 'url' => ['/edificio/create']],
                            ['label' => 'Consultar', 'url' => ['/edificio/index']],
                        ],
                    ],
					  [
                       'label' => 'Espacios',
                       'items' => [
                            ['label' => 'Crear', 'url' => ['/espacio/create']],
                            ['label' => 'Consultar', 'url' => ['/espacio/index']],
                        ],
                    ],
                ];
            if (Yii::$app->user->isGuest) {
                array_push($navItems,['label' => 'Iniciar sesión', 'url' => ['/user/login']]);
              } else {
                array_push($navItems,['label' => 'Cerrar sesión (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']]
                );
              }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $navItems,
            ]);
            NavBar::end();
        ?>

        <div class="container-fluid">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
