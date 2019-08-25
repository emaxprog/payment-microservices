<?php
/**
 * Файл контроллера DefaultController
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers;

use Yii;
use yii\base\Module;
use chulakov\components\web\Controller;
use common\modules\user\bootstrap\UserBootstrap;
use common\modules\user\models\User;

class DefaultController extends Controller
{
    /**
     * Конструктор контроллера
     *
     * @param string $id
     * @param Module $module
     * @param UserBootstrap $bootstrap
     * @param array $config
     */
    public function __construct($id, Module $module, UserBootstrap $bootstrap, array $config = [])
    {
        $bootstrap->bootstrap(Yii::$app);
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function accessRules()
    {
        return [
            'index'  => $this->createAccess('get', true, 'userView'),
            'view'   => $this->createAccess('get', true, 'userView'),
            'create' => $this->createAccess('get, post', true, 'userCreate'),
            'update' => $this->createAccess('get, post', true, 'userUpdate'),
            'delete' => $this->createAccess('post', true, 'userDelete'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index'  => 'chulakov\components\web\actions\IndexAction',
            'view'   => 'chulakov\components\web\actions\ViewAction',
            'create' => 'chulakov\components\web\actions\CreateAction',
            'update' => 'chulakov\components\web\actions\UpdateAction',
            'delete' => 'chulakov\components\web\actions\DeleteAction',
        ];
    }
}
