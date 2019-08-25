<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => getenv('db_dsn'),
            'username' => getenv('db_username'),
            'password' => getenv('db_password'),
            'charset' => getenv('db_charset'),
            'enableSchemaCache' => getenv('db_schema_cache'),
            'schemaCacheDuration' => getenv('db_schema_duration'),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow',
            'timeZone' => 'Europe/Moscow',
        ],
        'i18n' => [
            'translations' => [
                'ch/all' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'ch/all' => 'all.php'
                    ],
                ],
                'ch*' => [
                    'class' => 'common\messages\ModulesSource',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'fileStorage' => [
            'class' => 'chulakov\filestorage\FileStorage',
            'storageBaseUrl' => getenv('frontend_host'),
            'storagePath' => '@frontend/web',
        ],
        'imageComponent' => [
            'class' => 'chulakov\filestorage\ImageComponent',
            'driver' => 'imagick', // Базовые драйвера: gd и imagick
        ],
    ],
    'params' => [
        'adminEmail' => 'admin@example.com',
        'supportEmail' => 'support@example.com',
        'user.passwordResetTokenExpire' => 3600,
    ],
];
