<?php
return [
    'id' => 'ch-paymentacceptance',
    'name' => 'Chulakov paymentacceptance',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'basePath' => dirname(__DIR__),
    //'timeZone' => 'Europe/Moscow',
    'controllerNamespace' => 'paymentacceptance\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-ch-paymentacceptance',
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => 'common\modules\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-ch-paymentacceptance', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'ch-paymentacceptance',
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
            ],
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
    ],
];
