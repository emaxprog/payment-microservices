<?php
/**
 * Файл класса ResetPasswordForm
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\forms;

use yii\base\Model;
use yii\base\InvalidArgumentException;
use common\helpers\Password;

/**
 * Форма сброса пароля
 *
 * @property string $token read-only
 */
class ResetPasswordForm extends Model
{
    /**
     * @var string Новый пароль
     */
    public $password;
    /**
     * @var string Подтверждение нового пароля
     */
    public $confirm;

    /**
     * @var string Токен запроса на смену пароля
     */
    protected $token;

    /**
     * Конструктор формы смены пароля
     *
     * @param string $token
     * @param array $config
     */
    public function __construct($token, $config = [])
    {
        $this->token = $token;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (empty($this->token) || !is_string($this->token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'confirm'], 'required'],
            [['password'], 'string', 'min' => Password::DEFAULT_STRENGTH],
            [['password'], 'compare', 'compareAttribute' => 'confirm'],
        ];
    }

    /**
     * Read only токен
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
