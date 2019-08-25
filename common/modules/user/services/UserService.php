<?php
/**
 * Файл класса UserService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\services;

use yii\base\Exception;
use chulakov\components\services\Service;
use common\modules\user\repositories\UserRepository;
use common\modules\user\models\factories\UserFactory;
use common\modules\user\models\mappers\UserMapper;
use common\modules\user\models\forms\UserForm;
use common\modules\user\models\User;

class UserService extends Service
{
    /**
     * Конструктор сервиса
     *
     * @param UserRepository $repository
     * @param UserFactory $factory
     * @param UserMapper $mapper
     */
    public function __construct(
        UserRepository $repository,
        UserFactory $factory,
        UserMapper $mapper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
    }

    /**
     * Заполение модели из формы
     *
     * @param User $model
     * @param UserForm $form
     * @throws Exception
     */
    protected function fill($model, $form)
    {
        parent::fill($model, $form);
        if ($form->password) {
            $model->setPassword($form->password);
            $form->password = '';
        }
    }
}
