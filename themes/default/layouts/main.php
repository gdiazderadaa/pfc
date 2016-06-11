<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\Alert;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;

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
                /*['label' => 'Home', 'url' => ['/site/index']],*/
                [
                    'label' => Yii::t('app','Dashboard'),
                    'items' => [
                        /*[
                            'label' => Yii::t('app','Assets'),
                            'items' => [
                                [
                                    'label' => Yii::t('app','Hardware'), 
                                    'items' => [
                                        ['label' => Yii::t('app','Hardware Assets'), 'url' => ['/activo-hardware/index']],
                                        ['label' => Yii::t('app','Hardware Elements'), 'url' => ['/elemento-hardware/index']],
                                        '<li class="divider"></li>',
                                        ['label' => Yii::t('app','Hardware Asset Subcategories'), 'url' => ['/subcategoria-activo-hardware/index']],
                                    ]
                                ],
                                [
                                    'label' => Yii::t('app','Software'), 
                                    'items' => [
                                        ['label' => Yii::t('app','Software Assets'),'url' => ['/activo-software/index']],
                                        '<li class="divider"></li>',
                                        ['label' => Yii::t('app','Software Asset Subcategories'), 'url' => ['/subcategoria-activo-software/index']],
                                    ]
                                ],
                                [
                                    'label' => Yii::t('app','Infrastructure'), 
                                    'items' => [
                                        ['label' => Yii::t('app','Infrastructure Assets'),'url' => ['/activo-infraestructura/index']],
                                        '<li class="divider"></li>',
                                        ['label' => Yii::t('app','Infrastructure Asset Subcategories'), 'url' => ['/subcategoria-activo-infraestructura/index']],
                                    ]
                                ],
                                '<li class="divider"></li>',
                                ['label' => Yii::t('app','Features'), 'url' => ['/caracteristica/index']],
                            ],
                        ],
                        ['label' => Yii::t('app','Reports'), 'url' => ['/informe/index']],*/
                        ['label' => Yii::t('app','Buildings'), 'url' => ['/edificio/index']],
                        ['label' => Yii::t('app','Spaces'), 'url' => ['/espacio/index']],
                        /*['label' => Yii::t('app','Users'), 'url' => '#'['/usuario/index']],*/

                    ],
                ],
                /*[
                    'label' => Yii::t('app','Incidents'),
                    'items' => [
                        ['label' => Yii::t('app','Create'), 'url' => ['/incidencia/create']],
                        ['label' => Yii::t('app','Search'), 'url' => ['/incidencia/index']],
                    ],
                ],  */         
            ];
            if (Yii::$app->user->isGuest) {
                /*array_push($navItems,['label' => Yii::t('app','Login'), 'url' => ['/user/login']]);*/
              } else {
                /*array_push($navItems,['label' => Yii::t('app','Logout').' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']]
                );*/
              }
            echo NavX::widget([
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
