<?php
/**
 * Файл модели User
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models;

use Yii;
use yii\db\ActiveQuery;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use chulakov\filestorage\models\Image;
use common\modules\user\models\scopes\UserQuery;
use common\modules\user\models\mappers\UserMapper;
use common\helpers\Password;

/**
 * Класс модели для работы с данными таблицы "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $password write-only password
 * @property Image $avatar
 * @property UserRequest[] $requests
 */
class User extends IdentityRecord
{
    const UPLOAD_GROUP = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            TimestampBehavior::class,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return static::mapper()->modelRules();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return static::mapper()->modelLabels();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Валидация пароля
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Password::validate($password, $this->password_hash);
    }

    /**
     * Генерация хеша для нового пароля
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Password::hash($password);
    }

    /**
     * Генерация токена
     *
     * @param string $type
     * @param integer $expired
     * @return UserRequest
     * @throws Exception
     */
    public function generateToken($type, $expired = 0)
    {
        return UserRequest::create($type, $this, $expired);
    }

    /**
     * Аватар пользователя
     *
     * @return ActiveQuery
     */
    public function getAvatar()
    {
        return $this->hasOne(Image::class, ['object_id' => 'id'])
            ->andOnCondition(['group_code' => static::UPLOAD_GROUP]);
    }

    /**
     * @return ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(UserRequest::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }

    /**
     * @return UserQuery
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->byId($id)->one();
    }

    /**
     * Поиск пользователя по логину
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->byUsername($username)->one();
    }

    /**
     * @return UserMapper
     */
    public static function mapper()
    {
        return UserMapper::instance();
    }
}
