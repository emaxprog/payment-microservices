<?php
/**
 * Файл класса ProfileFactory
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */


namespace common\modules\user\models\factories;

use chulakov\components\exceptions\FormException;
use common\modules\user\models\forms\AvatarForm;
use common\modules\user\models\forms\ProfileForm;
use common\modules\user\models\mappers\ProfileMapper;
use common\modules\user\models\User;

class ProfileFactory
{
    /**
     * Создать форму
     *
     * @param ProfileMapper $mapper
     * @param User $model
     * @param array $config
     * @return ProfileForm
     * @throws FormException
     */
    public function makeForm($mapper, $model, $config = [])
    {
        return new ProfileForm($mapper, $model, $config);
    }

    /**
     * Создание формы для загрузки аватара
     *
     * @param User $model
     * @param array $config
     * @return AvatarForm
     */
    public function makeAvatarForm($model, $config = [])
    {
        return new AvatarForm($model, $config);
    }
}
