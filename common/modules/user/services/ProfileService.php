<?php
/**
 * Файл класса ProfileService
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\services;

use yii\base\Exception;
use chulakov\filestorage\models\BaseFile;
use chulakov\components\exceptions\FormException;
use chulakov\components\exceptions\SaveModelException;
use chulakov\components\exceptions\DeleteModelException;
use common\modules\user\repositories\UserRepository;
use common\modules\user\models\factories\ProfileFactory;
use common\modules\user\models\mappers\ProfileMapper;
use common\modules\user\models\forms\ProfileForm;
use common\modules\user\models\forms\AvatarForm;
use common\modules\user\models\User;

class ProfileService
{
    /**
     * @var UserRepository
     */
    protected $repository;
    /**
     * @var ProfileFactory
     */
    protected $factory;
    /**
     * @var ProfileMapper
     */
    protected $mapper;

    /**
     * Конструктор сервиса профиля пользователя
     *
     * @param UserRepository $repository
     * @param ProfileMapper $mapper
     * @param ProfileFactory $factory
     */
    public function __construct(
        UserRepository $repository,
        ProfileFactory $factory,
        ProfileMapper $mapper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mapper = $mapper;
    }

    /**
     * Создание формы для профиля пользователя
     *
     * @param User $model
     * @param array $config
     * @return ProfileForm
     * @throws FormException
     */
    public function form($model, $config = [])
    {
        return $this->factory->makeForm(
            $this->mapper, $model, $config
        );
    }

    /**
     * Создание формы для загрузки аватара
     *
     * @param User $model
     * @param array $config
     * @return AvatarForm
     */
    public function avatarForm($model, $config = [])
    {
        return $this->factory->makeAvatarForm(
            $model, $config
        );
    }

    /**
     * Обновление профиля
     *
     * @param User $model
     * @param ProfileForm $form
     * @return bool
     * @throws SaveModelException
     * @throws Exception
     */
    public function update($model, $form)
    {
        $this->fill($model, $form);
        if ($this->repository->save($model)) {
            return true;
        }
        return false;
    }

    /**
     * Смена аватара пользователя
     *
     * @param AvatarForm $form
     * @throws DeleteModelException
     */
    public function changeAvatar($form)
    {
        $old = $form->fileAttached;
        if ($avatar = $form->upload()) {
            $form->fileAttached = $avatar;
            if ($old) {
                $this->dropAvatar($old);
            }
        }
    }

    /**
     * Удаление аватара пользователя
     *
     * @param BaseFile $avatar
     * @throws DeleteModelException
     */
    public function dropAvatar($avatar)
    {
        try {
            $avatar->delete();
        } catch (\Exception $e) {
            throw new DeleteModelException(
                $e->getMessage(), $e->getCode(), $e
            );
        } catch (\Throwable $e) {
            throw new DeleteModelException(
                $e->getMessage(), $e->getCode(), $e
            );
        }
    }

    /**
     * Заполнение модели из формы
     *
     * @param User $model
     * @param ProfileForm $form
     * @throws Exception
     */
    protected function fill($model, $form)
    {
        $model->setAttributes($form->getAttributes(
            $this->mapper->fillAttributes()
        ));
        if (!empty($form->password)) {
            $model->setPassword($form->password);
        }
    }
}
