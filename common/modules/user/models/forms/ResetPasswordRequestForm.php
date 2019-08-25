<?php
/**
 * Файл класса ResetPasswordRequestForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\forms;

use Yii;
use yii\base\Model;
use chulakov\components\validators\ClearMultibyteValidator;
use common\modules\user\models\User;

/**
 * Форма запроса на смену пароля
 */
class ResetPasswordRequestForm extends Model
{
    /**
     * @var string E-mail адрес пользователя
     */
    public $username;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', ClearMultibyteValidator::class],
            ['username', 'required'],
            ['username', 'exist',
                'targetClass' => User::class,
                'message' => 'Пользователь с данным логином не найден.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('ch/user', 'Username'),
        ];
    }
}
