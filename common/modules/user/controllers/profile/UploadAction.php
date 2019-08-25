<?php
/**
 * Файл класса UploadAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\profile;

use yii\web\Response;
use yii\base\Controller;
use chulakov\components\web\actions\Action;
use common\modules\user\services\ProfileService;
use common\modules\user\models\User;

class UploadAction extends Action
{
    /**
     * @var ProfileService
     */
    protected $service;

    /**
     * Консктор действия загрузки аватара
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
     * Загрузка изображения на аватар
     *
     * @return string|Response
     */
    public function run()
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $model = $this->service->avatarForm($user);

        // Отправка валидной информации о загрузке
        if ($model->validate()) {
            try {
                $this->service->changeAvatar($model);
                return $this->controller->asJson([
                    'initialPreview' => $model->getInitialPreview(),
                    'initialPreviewConfig' => $model->getInitialPreviewConfig(),
                ]);
            } catch (\Exception $e) {
                $model->addError('file', $e->getMessage());
                \Yii::error($e);
            }
        }

        // Получение ошибок
        $error = 'Не удалось сохранить файл.';
        if ($model->hasErrors()) {
            $error = implode("\n", $model->getErrorSummary(true));
        }
        return $this->controller->asJson(['error' => $error]);
    }
}
