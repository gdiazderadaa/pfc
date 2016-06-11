<?php
use kartik\datecontrol\Module;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Coruxa',
    'language'=>'es', // spanish
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\components\Bootstrap',
    ],
    'modules' =>  [  
    		'actionlog' => [
    				'class' => 'cakebake\actionlog\Module',
    		],
//         'user' => [
//             'class' => 'app\models\Usuario',
//             'enableUnconfirmedLogin' => true,
//             'confirmWithin' => 21600,
//             'cost' => 12,
//             'admins' => ['admin']
//         ],
        'dynamicrelations' => [
            'class' => '\synatree\dynamicrelations\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to  
            // use your own export download action or custom translation 
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',
     
            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd/MM/yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd/MM/yyyy hh:mm:ss a', 
            ],
            
            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d', 
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
     
            // set your display timezone
            //'displayTimezone' => 'Europe/Madrid',
            
            // set your timezone for date saved to db
            //'saveTimezone' => 'UTC',
            
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
     
            // default settings for each widget from kartik\widgets used when autoWidget is true
            // 'autoWidgetSettings' => [
            //     Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
            //     Module::FORMAT_DATETIME => [], // setup if needed
            //     Module::FORMAT_TIME => [], // setup if needed
            // ],
            
            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            // 'widgetSettings' => [
            //     Module::FORMAT_DATE => [
            //         'class' => 'yii\jui\DatePicker', // example
            //         'options' => [
            //             'dateFormat' => 'php:d-M-Y',
            //             'options' => ['class'=>'form-control'],
            //         ]
            //     ]
            // ]
            // other settings
        ]
    ],
    'components' => [
    		'user' => [
    				'identityClass' => 'app\models\Usuario',
    		],
    		'ldap' => [
    				'class'=>'Edvlerblog\Ldap',
    				'options'=> [
    						'ad_port'      => 389,
    						'domain_controllers'    => array('localhost'),
    						//'account_suffix' =>  '@ident.uniovi.es',
    						'base_dn' => 'dc=ident,dc=uniovi,dc=es',
    						// for basic functionality this could be a standard, non privileged domain user (required)
    						'admin_username' => 'cn=manager,dc=ident,dc=uniovi,dc=es',
    						'admin_password' => 'secret',
    						'autoConnect' => false
    				],
   				
    		],
        'assetManager' => [
            'linkAssets' => true,
        	'appendTimestamp' => true,
             'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-epi-green',
                ],
            ],
        ],

         'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
            'numberFormatterSymbols' => [
                NumberFormatter::CURRENCY_SYMBOL => '&#8364;',
            ],
            'locale' => 'es-ES',
            'nullDisplay' => '',
       ],
        'urlManager' => [
          'showScriptName' => false,
          'enablePrettyUrl' => true,
          'baseUrl' => 'http://localhost/pfc/web'
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Ha1Fa8GubI4bNSKaVyLplNaSS1526mOX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@app/mailer',
                'useFileTransport' => false,
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => 'smtp.gmail.com',
                    'username' => 'buffonin@gmail.com',
                    'password' => 'jarenai',
                    'port' => '587',
                    'encryption' => 'tls',
                                ],
            ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'class' => 'singrana\thememanager\components\ThemeManager',
                'current' => 'adminLTE',

                'themes'    => [
                    'adminLTE'  => [
                        'pathMap' => [
                            // '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                            '@app/views' => '@app/themes/adminLTE'
                        ],
                    ],
                    'default'  => [
                        'pathMap' => [
                            //'@app/views' => '@app/views'
                             '@app/views' => '@app/themes/default'
                        ],
                    ],
                ]
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20','93.156.123.119','10.240.91.130'],
    ];
}

return $config;
