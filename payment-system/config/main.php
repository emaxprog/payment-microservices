<?php
return [
    'id' => 'ch-paymentsystem',
    'name' => 'Chulakov paymentsystem',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'basePath' => dirname(__DIR__),
    //'timeZone' => 'Europe/Moscow',
    'controllerNamespace' => 'paymentsystem\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'payment' => 'common\modules\paymentsystem\Module',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-ch-paymentsystem',
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => 'json',
        ],
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-ch-paymentsystem', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'ch-paymentsystem',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'payment' => 'payment/payment/index'
            ],
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
    ],
];
