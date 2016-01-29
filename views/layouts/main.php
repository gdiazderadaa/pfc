<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Alert;
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
                'brandLabel' => 'Gestión de activos e incidencias',//Html::img('@web/images/uniovi-flat-logo-small.png', ['alt'=>Yii::$app->name]),
                //'brandOptions' => ['class' => 'img-responsive'],//options of the brand
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
                        'label' => 'Administracion',
                        'items' => [
                           [
                               'label' => 'Inventario',
                               'items' => [
                                    ['label' => 'Hardware', 'url' => ['/activo-hardware/index']],
                                    ['label' => 'Software', 'url' => ['/activo-software/index']],
                                    ['label' => 'Infraestructura', 'url' => ['/activo-infraestructura/index']],
                                ],
                            ],
                            ['label' => 'Informes', 'url' => ['/informe/index']],
                            ['label' => 'Edificios', 'url' => ['/edificio/index']],
                            ['label' => 'Espacios', 'url' => ['/espacio/index']],
                            ['label' => 'Usuarios', 'url' => ['/usuario/index']],

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

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
                <?php 
                    if($flash = Yii::$app->session->getFlash('danger')){
                        echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => $flash]);
                    }
                    elseif($flash = Yii::$app->session->getFlash('warning')){
                        echo Alert::widget(['options' => ['class' => 'alert-warning'], 'body' => $flash]);
                    }
                    elseif($flash = Yii::$app->session->getFlash('info')){
                        echo Alert::widget(['options' => ['class' => 'alert-info'], 'body' => $flash]);
                    }
                    elseif($flash = Yii::$app->session->getFlash('success')){
                        echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => $flash]);
                    }
                ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <div itemscope itemtype="http://schema.org/EducationalOrganization">
                <a itemprop="url" href="http://www.epigijon.uniovi.es/">
                    &copy;<span itemprop="name"><strong>Escuela Politécnica de Ingeniería de Gijón</strong></span>
                </a>
                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <span itemprop="streetAddress">Campus de Gijón s/n</span> |
                    <span itemprop="postalCode">33203</span>
                    <span itemprop="addressLocality">Gijón</span>-
                    <span itemprop="addressRegion">Asturias</span> |
                    <span itemprop="addressCountry">Spain</span>
                </div>
            </div>

        </div>
    </footer>

<?php
yii\bootstrap\Modal::begin([
    'header' => '<span id="modalHeaderTitle"></span>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
yii\bootstrap\Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
