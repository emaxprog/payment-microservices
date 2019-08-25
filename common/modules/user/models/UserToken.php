<?php
/**
 * Файл класса UserToken
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\modules\user\models\scopes\UserTokenQuery;

/**
 * Ключи авторизации пользователя
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property string $ip_address
 * @property string $user_agent
 * @property integer $expired_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserToken extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * Создание нового токена
     *
     * @param integer $expire
     * @param string $userAgent
     * @param string $ipAddress
     * @return static
     */
    public static function create($expire, $userAgent = '', $ipAddress = '')
    {
        $model = new static();

        $model->ip_address = $ipAddress;
        $model->user_agent = $userAgent;
        $model->updateExpire($expire);
        $model->updateToken();

        return $model;
    }

    /**
     * Модель поиска токенов в базе
     *
     * @return UserTokenQuery
     */
    public static function find()
    {
        return new UserTokenQuery(get_called_class());
    }

    /**
     * Поиск идентификации по токену
     *
     * @param string $token
     * @return ActiveQuery
     */
    public static function findByToken($token)
    {
        return static::find()->byToken($token);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['user_id', 'expired_at'], 'number'],
            [['user_agent'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 16],
            [['token'], 'string', 'max' => 64],
        ];
    }

    /**
     * Проверка на истечение времени
     *
     * @return true|false
     */
    public function isExpired()
    {
        return $this->expired_at <= time();
    }

    /**
     * Получить владельца токена
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Обновление времени истечении токена
     *
     * @param integer $expire
     */
    public function updateExpire($expire)
    {
        $this->expired_at = time() + $expire;
    }

    /**
     * Обновление токена
     *
     * @param int $length
     * @throws \yii\base\Exception
     */
    public function updateToken($length = 32)
    {
        $this->token = \Yii::$app->security->generateRandomString($length);
    }
}
