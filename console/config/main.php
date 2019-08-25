<?php
return [
    'id' => 'ch-console',
    'name' => 'Chulakov Console',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    //'timeZone' => 'Europe/Moscow',
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        // Use command: ./yii assets/clear --projects=@frontend
        'assets' => [
            'class' => 'chulakov\components\console\AssetsController',
            'projects' => ['@frontend', '@admin'],
            'assetsPath' => 'web/assets',
        ],
        'admin' => [
            'class' => 'common\modules\user\console\AdminController',
            'role' => 'admin',
        ],
        // 'fixture' => [
        //     'class' => 'yii\console\controllers\FixtureController',
        //     'namespace' => 'common\fixtures',
        // ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
                '@common/modules/user/migrations',
                '@vendor/oleg-chulakov-studio/yii2-filestorage/src/migrations',
            ],
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
    ],
];
