<?php
/**
 * Файл класса LoginAction
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers\auth;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use chulakov\components\web\actions\Action;
use common\modules\user\services\AuthService;

class LoginAction extends Action
{
    /**
     * @var string Шаблон формы авторизации
     */
    public $layout;
    /**
     * @var float|int Время истечения токена
     */
    public $expire = 86400 * 30;

    /**
     * @var AuthService
     */
    protected $service;

    /**
     * Конструктор действия авторизации пользователя
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
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goBack();
        }

        $model = $this->service->loginForm();
        $request = Yii::$app->request;

        if ($model->load($request->post()) && $model->validate()) {
            $user = $model->getUser();
            if ($this->service->login($user, $this->expire, $request)) {
                if (Yii::$app->user->login($user, $this->expire)) {
                    return $this->controller->goBack();
                }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
