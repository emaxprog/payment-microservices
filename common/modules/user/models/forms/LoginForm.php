<?php

namespace common\modules\user\models\forms;

use yii\base\Model;
use common\modules\user\models\User;
use chulakov\components\validators\ClearMultibyteValidator;

/**
 * Форма авторизации
 */
class LoginForm extends Model
{
    /**
     * @var string Имя пользователя
     */
    public $username;
    /**
     * @var string Пароль
     */
    public $password;
    /**
     * @var bool Запомнить пользователя
     */
    public $rememberMe = true;

    /**
     * @var User
     */
    protected $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], ClearMultibyteValidator::class],
            [['username', 'password'], 'required'],

            [['rememberMe'], 'filter', 'filter' => function($value) {
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }],
            [['rememberMe'], 'boolean', 'trueValue' => true, 'falseValue' => false, 'strict' => true],

            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('ch/user', 'Username'),
            'password' => \Yii::t('ch/user', 'Password'),
            'rememberMe' => \Yii::t('ch/user', 'Remember me'),
        ];
    }

    /**
     * Валидация пароля
     *
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params = [])
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->{$attribute})) {
                $this->addError($attribute, 'Неверное Имя пользователя или Пароль.');
            }
        }
    }

    /**
     * Поиск пользователя
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
