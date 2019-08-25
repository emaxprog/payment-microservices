<?php
/**
 * Файл класса UserBootstrap
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\bootstrap;

use yii\base\BootstrapInterface;

class UserBootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        \Yii::$container->setDefinitions([
            'chulakov\components\models\mappers\Mapper' => 'common\modules\user\models\mappers\UserMapper',
            'chulakov\components\models\factories\FactoryInterface' => 'common\modules\user\models\factories\UserFactory',
            'chulakov\components\repositories\Repository' => 'common\modules\user\repositories\UserRepository',
            'chulakov\components\services\Service' => 'common\modules\user\services\UserService',
        ]);
    }
}
