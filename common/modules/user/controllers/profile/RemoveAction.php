<?php
/**
 * Файл класса RemoveAction
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

class RemoveAction extends Action
{
    /**
     * @var ProfileService
     */
    protected $service;

    /**
     * Конструктор действия удаления аватара
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
     * @throws BadRequestHttpException
     */
    public function run()
    {
        /** @var User $user */
        if ($user = \Yii::$app->user->identity) {
            if ($avatar = $user->avatar) {
                if ($avatar->id != \Yii::$app->request->post('id')) {
                    throw new BadRequestHttpException(
                        'Не удалось удалить аватар или он удален ранее.'
                    );
                }
            }
            try {
                $this->service->dropAvatar($user->avatar);
                $this->controller->asJson([
                    'success' => true,
                ]);
            } catch (\Exception $e) {
                throw new BadRequestHttpException(
                    $e->getMessage(), $e->getCode(), $e
                );
            }
        }
        return $this->controller->asJson([]);
    }
}
