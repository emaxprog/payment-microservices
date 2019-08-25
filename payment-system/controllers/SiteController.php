<?php
namespace paymentsystem\controllers;

use chulakov\components\rest\Controller;
use chulakov\components\base\AccessRule;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'index' => $this->createAccess('get', true),
            'error' => $this->createAccess('get', true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Отображения дефолтного роута
     *
     * @return array
     */
    public function actionIndex()
    {
        return $this->successResult();
    }
}
