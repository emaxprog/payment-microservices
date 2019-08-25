<?php
/**
 * Файл класса ProfileController
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\controllers;

use chulakov\components\base\AccessRule;
use chulakov\components\web\Controller;

class ProfileController extends Controller
{
    /**
     * Список правил доступа к экшенам контроллера.
     *
     * @return AccessRule[]
     */
    public function accessRules()
    {
        return [
            'index' => $this->createAccess('get,post', true, 'profileUpdate'),
            'upload' => $this->createAccess('post', true, 'profileUpdate'),
            'remove' => $this->createAccess('post', true, 'profileUpdate'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => 'common\modules\user\controllers\profile\IndexAction',
            'upload' => 'common\modules\user\controllers\profile\UploadAction',
            'remove' => 'common\modules\user\controllers\profile\RemoveAction',
        ];
    }
}
