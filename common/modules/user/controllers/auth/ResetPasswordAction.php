<?php
/**
 * Файл класса ResetPasswordAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\auth;

use Yii;
use yii\base\Exception;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use chulakov\components\web\actions\Action;
use chulakov\components\exceptions\ModelException;
use chulakov\components\exceptions\NotFoundModelException;
use common\modules\user\services\AuthService;

/**
 * Действие сброса пароля
 */
class ResetPasswordAction extends Action
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
     * Конструктор действия сброса пароля
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
     * @param string $token
     * @return string|Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function run($token)
    {
        try {

            $user = $this->service->findUserByToken($token);
            $model = $this->service->passwordReset($token);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($this->service->changePassword($user, $model)) {
                    $this->successFlash();
                    return $this->controller->goHome();
                }
            }

            return $this->render('reset', [
                'model' => $model,
            ]);

        } catch (NotFoundModelException $e) {
            throw new NotFoundHttpException(
                $e->getMessage(), $e->getCode(), $e
            );
        } catch (ModelException $e) {
            $this->warningFlash($e->getMessage());
            return $this->refresh();
        } catch (\Exception $e) {
            throw new BadRequestHttpException(
                $e->getMessage(), $e->getCode(), $e
            );
        }
    }

    /**
     * Добавление оповещения об отправке в интерфейс
     */
    protected function successFlash()
    {
        Yii::$app->session->setFlash('success', Yii::t('ch/user', 'Password success changed.'));
    }

    /**
     * Добавление оповещения об ошибке в интерфейс
     *
     * @param string $message
     */
    protected function warningFlash($message)
    {
        Yii::$app->session->setFlash('warning', Yii::t('ch/user', $message));
    }
}
