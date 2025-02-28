<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-WebApp',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'WebApp\controllers',
    'aliases' => [
        '@baseweb' => '@WebApp/web',
    ],
    'modules' => [
        'v1' => [
            'class' => 'WebApp\modules\v1\Module',
            "defaultRoute" => "site/index"
        ],
        'lp' => [
            'class' => 'WebApp\modules\lp\Module',
            "defaultRoute" => "site/index"
        ],
        'v1' => [
            'class' => 'WebApp\modules\v1\Module',
            "defaultRoute" => "site/index",
            'modules' => [
                'lp' => [
                    'class' => 'WebApp\modules\v1\modules\lp\Module',
                    "defaultRoute" => "site/index",
                ],
            ],

        ],
        // 'admin' => [
        //     'class' => 'mdm\admin\Module',
        // ]
    ],

    'components' => [
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ]

        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-WebApp', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the WebApp
            'name' => 'advanced-WebApp',

            'class' => 'yii\web\Session',
            'savePath' => sys_get_temp_dir(), // Uses a writable temp directory
   
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 'orsar/cms-content/<id:[\w-]+>' => 'orsar/cms-content/update',
                // 'orsar/cms-content/<id:[\w-]+>' => 'orsar/cms-content/view',

                [
                    'class' => 'common\components\uuid\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'v1/banner',
                        'v1/cms-content',
                        'v1/commerce-link',
                        'v1/product',
                        'v1/product-detail',
                        'v1/upload',

                        'v1/lp/banner',
                        'v1/lp/cms-content',
                        'v1/lp/commerce-link',
                        'v1/lp/product',
                        'v1/lp/product-detail',
                        'v1/lp/upload',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        "v1/blog",
                        "v1/job",
                        "v1/category",
                        "v1/feature",
                        "v1/color",
                        "v1/theme",
                        "v1/product",
                        "v1/banner",
                        "v1/contact-us",
                        "v1/subscriber",
                        // lp
                        "lp/category",
                        "lp/feature",
                        "lp/color",
                        "lp/theme",
                        "lp/product",
                        "lp/product-color",
                        "lp/product-packaging",
                        "lp/packaging",
                        "lp/banner",
                        "lp/blog",
                        "lp/contact-us",
                        "lp/subscriber",
                    ],
                    'extraPatterns' => [
                        'OPTIONS search' => 'options',
                        'OPTIONS view' => 'options',
                        'OPTIONS update' => 'options',
                        'OPTIONS list' => 'options',


                    ]
                ]
            ],
        ],

    ],
    'params' => $params,
];
