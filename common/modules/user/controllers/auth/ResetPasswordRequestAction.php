<?php
/**
 * Файл класса ResetPasswordRequestAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\auth;

use Yii;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\base\InvalidConfigException;
use chulakov\components\web\actions\Action;
use chulakov\components\exceptions\NotFoundModelException;
use common\modules\user\mail\ResetPasswordMessage;
use common\modules\user\services\AuthService;
use common\modules\user\models\UserRequest;

/**
 * Действие запроса на восстановление пароля
 */
class ResetPasswordRequestAction extends Action
{
    /**
     * @var string Шаблон формы авторизации
     */
    public $layout;

    /**
     * @var AuthService
     */
    protected $service;

    /**
     * Конструктор действия запроса на восстановление пароля
     *
     * @param string $id
     * @param Controller $controller
     * @param AuthService $service
     * @param array $config
     */
    public function __construct($id, Controller $controller, AuthService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $controller, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!empty($this->layout)) {
            $this->controller->layout = $this->layout;
        }
    }

    /**
     * Выполнение действия
     *
     * @return string|Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function run()
    {
        try {

            $model = $this->service->passwordRequest();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($request = $this->service->resetPassword($model)) {
                    $this->sendMessage($request);
                    $this->successFlash();
                    return $this->refresh();
                } else {
                    $this->warningFlash();
                }
            }

            return $this->render('recovery', [
                'model' => $model,
            ]);

        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException(
                $e->getMessage(), $e->getCode(), $e
            );
        } catch (\Exception $e) {
            throw new BadRequestHttpException(
                $e->getMessage(), $e->getCode(), $e
            );
        }
    }

    /**
     * Отправка оповещения на почту
     *
     * @param UserRequest $request
     * @throws InvalidConfigException
     */
    protected function sendMessage(UserRequest $request)
    {
        ResetPasswordMessage::create()->send($request->user->email, [
            'url' => Url::to(['reset', 'token' => $request->token], true),
            'user' => $request->user,
        ]);
    }

    /**
     * Добавление оповещения об отправке в интерфейс
     */
    protected function successFlash()
    {
        Yii::$app->session->setFlash('success', Yii::t('ch/user', 'The information for password recovery sent to your email.'));
    }

    /**
     * Добавление оповещения об ошибке в интерфейс
     */
    protected function warningFlash()
    {
        Yii::$app->session->setFlash('warning', Yii::t('ch/user', 'The request for password recovery failed.'));
    }
}
