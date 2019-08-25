<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

(new Symfony\Component\Dotenv\Dotenv)
    ->load(__DIR__ . '/../../common/config/serv.env');

require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

$config = chulakov\components\config\Configurator::config(
    [
        '@common/config/main.php',
        '@common/config/main-local.php',
        '@paymentsystem/config/main.php',
        '@paymentsystem/config/main-local.php'
    ],
    '@common/config/serv.env',
    '@paymentsystem/runtime/cached.bin'
);

(new yii\web\Application($config))->run();
