<?php
/**
 * Файл класса UserRequest
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models;

use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Класс модели для работы с данными таблицы "user_request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $type
 * @property string  $token
 * @property integer $expired_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class UserRequest extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_request}}';
    }

    /**
     * Создание токена
     *
     * @param string $type
     * @param User $user
     * @param int $expired
     * @return UserRequest
     * @throws Exception
     */
    public static function create($type, $user, $expired = 0)
    {
        $model = new static();

        $model->user_id = $user->id;
        $model->type = $type;
        $model->token = \Yii::$app->security->generateRandomString();
        $model->updateExpire($expired);

        $user->link('requests', $model);

        return $model;
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
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Проверка на истичение токена
     *
     * @return bool
     */
    public function isExpired()
    {
        if ($this->expired_at > 0) {
            return $this->expired_at < time();
        }
        return false;
    }

    /**
     * Обновление времени истечении токена
     *
     * @param integer $expire
     */
    public function updateExpire($expire = 0)
    {
        if ($expire > 0) {
            $this->expired_at = time() + $expire;
        }
    }
}
