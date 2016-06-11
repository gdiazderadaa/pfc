<aside class="main-sidebar">

    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">   
            <div class="brand">
                <img alt="Epi Gijón logo" src="<?= yii\helpers\Url::to('@web/images/epi-logo.png') ?>" />        
            </div>
            <!--<div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>-->
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    // ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    // ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => Yii::t('app','Assets'),
                        'icon'  => 'fa fa-barcode',
                        'url'   => '#',
                        'items' => [
                             [
                                'label' => Yii::t('app','Hardware'),
                                'icon'  => 'fa fa-laptop',
                                'url'   => '#',
                                'items' => [
                                    [
                                    'label' => Yii::t('app','Inventory'),
                                    'icon'  => 'fa fa-list-ul',
                                    'url'   => ['/activo-hardware'],
                                    'items' => [],
                                    ],
                                    [
                                    'label' => Yii::t('app','Component Models'),
                                    'icon'  => 'fa fa-bookmark-o',
                                    'url'   => ['/modelo-componente-hardware'],
                                    'items' => [],
                                    ],
                                    [
                                    'label' => Yii::t('app','Components'),
                                    'icon'  => 'fa fa-hdd-o',
                                    'url'   => ['/componente-hardware'],
                                    'items' => [],
                                    ],
                                ]
                            ],
                            [
                                'label' => Yii::t('app','Software'),
                                'icon'  => 'glyphicon glyphicon-cd',
                                'url'   => ['/activo-software'],
                                'items' => [
                                    
                                ]
                            ],
                            [
                                'label' => Yii::t('app','Infrastructure'),
                                'icon'  => 'fa fa-lightbulb-o',
                                'url'   => ['/activo-infraestructura'],
                                'items' => [
                                    
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => Yii::t('app','Incidents'),
                        'icon'  => 'fa fa-warning',
                        'url'   => '#',
                        'items' => [
                        	
                        ]
                    ],
                    [
                        'label' => Yii::t('app','Admin'),
                        'icon'  => 'fa fa-wrench',
                        'url'   => '#',
                        'items' => [
                        		[
	                        		'label' => Yii::t('app','Buildings'),
	                        		'icon'  => 'fa fa-building',
	                        		'url'   => ['/edificio'],
	                        		'items' => []
                        		],
                        		[
                        			'label' => Yii::t('app','Rooms'),
                        			'icon'  => 'fa fa-map-marker',
                        			'url'   => ['/espacio'],
                        			'items' => []
                        		],
                        		[
	                        		'label' => Yii::t('app','Categories'),
	                        		'icon'  => 'fa fa-tag',
	                        		'url'   => ['/categoria'],
	                        		'items' => []
                        		],
                        		[
	                        		'label' => Yii::t('app','Features'),
	                        		'icon'  => 'glyphicon glyphicon-list-alt',
	                        		'url'   => ['/caracteristica'],
	                        		'items' => []
                        		],
                        		[
                        			'label' => 'Log', 
                        			'icon'  => 'fa fa-history',
                        			'url' => ['/actionlog/log/index']],
                        ]
                    ],
                    [
                        'label' => Yii::t('app','Users'),
                        'icon'  => 'fa fa-users',
                        'url'   => '#',
                        'items' => [
                            
                        ]
                    ],
                    [
                        'label' => Yii::t('app','Reports'),
                        'icon'  => 'fa fa-pie-chart',
                        'url'   => '#',
                        'items' => [
                            
                        ]
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
