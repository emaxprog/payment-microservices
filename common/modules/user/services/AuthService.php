<?php
/**
 * Файл класса UserService
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\services;

use yii\web\Request;
use yii\base\Exception;
use chulakov\components\exceptions\NotFoundModelException;
use chulakov\components\exceptions\DeleteModelException;
use chulakov\components\exceptions\SaveModelException;
use common\modules\user\repositories\UserRepository;
use common\modules\user\models\factories\AuthFactory;
use common\modules\user\models\forms\ResetPasswordRequestForm;
use common\modules\user\models\forms\ResetPasswordForm;
use common\modules\user\models\forms\LoginForm;
use common\modules\user\models\UserRequest;
use common\modules\user\models\User;

/**
 * Сервис обработки Пользователя
 */
class AuthService
{
    /**
     * @var AuthFactory
     */
    protected $factory;
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * Конструктор сервиса авторизации
     *
     * @param UserRepository $repository
     * @param AuthFactory $factory
     */
    public function __construct(
        UserRepository $repository,
        AuthFactory $factory
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Форма авторизации
     *
     * @param array $config
     * @return LoginForm
     */
    public function loginForm($config = [])
    {
        return $this->factory->makeLogin($config);
    }

    /**
     * Форма запроса на смену пароля
     *
     * @param array $config
     * @return ResetPasswordRequestForm
     */
    public function passwordRequest($config = [])
    {
        return $this->factory->makePasswordRequest($config);
    }

    /**
     * Форма сброса пароля
     *
     * @param string $token
     * @param array $config
     * @return ResetPasswordForm
     */
    public function passwordReset($token, $config = [])
    {
        return $this->factory->makePasswordReset($token, $config);
    }

    /**
     * Запрос на смену пароля
     *
     * @param ResetPasswordRequestForm $form
     * @return UserRequest
     * @throws NotFoundModelException
     * @throws Exception
     */
    public function resetPassword($form)
    {
        $user = $this->repository->findByUsername($form->username);
        if ($request = $user->generateToken('password', 0)) {
            return $request;
        }
        return null;
    }

    /**
     * Генерация токенов авторизации
     *
     * @param User $user
     * @param int $expire
     * @param Request|null $request
     * @return bool
     */
    public function login(User $user, $expire = 0, $request = null)
    {
        if ($expire > 0) {
            return $user->generateAuthKey(
                $expire, $request->getUserAgent(), $request->getUserIP()
            );
        }
        return true;
    }

    /**
     * Смена пароля для пользователя
     *
     * @param User $user
     * @param ResetPasswordForm $form
     * @return bool
     * @throws Exception
     * @throws SaveModelException
     * @throws DeleteModelException
     */
    public function changePassword(User $user, ResetPasswordForm $form)
    {
        $user->setPassword($form->password);
        foreach ($user->requests as $request) {
            if ($request->token == $form->token) {
                try {
                    $request->delete();
                } catch (\Exception $e) {
                    throw new DeleteModelException(
                        $e->getMessage(), $e->getCode(), $e
                    );
                } catch (\Throwable $e) {
                    throw new DeleteModelException(
                        $e->getMessage(), $e->getCode(), $e
                    );
                }
                break;
            }
        }
        return $this->repository->save($user);
    }

    /**
     * Поиск пользователя по токену
     *
     * @param string $token
     * @return User
     * @throws NotFoundModelException
     */
    public function findUserByToken($token)
    {
        return $this->repository->findByToken('password', $token);
    }
}
