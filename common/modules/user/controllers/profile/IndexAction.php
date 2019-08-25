<?php
/**
 * Файл класса IndexAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\profile;

use yii\base\Controller;
use yii\web\BadRequestHttpException;
use chulakov\components\web\actions\Action;
use common\modules\user\services\ProfileService;
use common\modules\user\models\User;

class IndexAction extends Action
{
    /**
     * @var ProfileService
     */
    protected $service;

    /**
     * Конструктор вывода профиля пользователя
     *
     * @param string $id
     * @param Controller $controller
     * @param ProfileService $service
     * @param array $config
     */
    public function __construct($id, Controller $controller, ProfileService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * Выполнение действия
     *
     * @return string
     * @throws BadRequestHttpException
     */
    public function run()
    {
        try {
            /** @var User $user */
            $user = \Yii::$app->user->identity;
            $request = \Yii::$app->request;

            $profile = $this->service->form($user);
            $avatar = $this->service->avatarForm($user);

            if ($profile->load($request->bodyParams) && $profile->validate()) {
                if ($this->service->update($user, $profile)) {
                    return $this->refresh();
                }
            }

            $profile->confirm = '';
            $profile->password = '';
            return $this->render('index', compact(
                'avatar', 'profile'
            ));
        } catch (\Exception $e) {
            throw new BadRequestHttpException(
                $e->getMessage(), $e->getCode(), $e
            );
        }
    }
}
