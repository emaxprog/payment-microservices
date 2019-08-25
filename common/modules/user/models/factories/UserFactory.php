<?php
/**
 * Файл класса UserFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\factories;

use chulakov\components\exceptions\FormException;
use chulakov\components\models\factories\FactoryInterface;
use common\modules\user\models\mappers\UserMapper;
use common\modules\user\models\search\UserSearch;
use common\modules\user\models\forms\UserForm;
use common\modules\user\models\User;

class UserFactory implements FactoryInterface
{
    /**
     * Создать модель
     *
     * @param array $config
     * @return User
     */
    public function makeModel($config = [])
    {
        return new User($config);
    }

    /**
     * Создать поисковую модель
     *
     * @param array $config
     * @return UserSearch
     */
    public function makeSearch($config = [])
    {
        return new UserSearch($config);
    }

    /**
     * Создать форму
     *
     * @param UserMapper $mapper
     * @param User $model
     * @param array $config
     * @return UserForm
     * @throws FormException
     */
    public function makeForm($mapper, $model = null, $config = [])
    {
        return new UserForm($mapper, $model, $config);
    }
}
