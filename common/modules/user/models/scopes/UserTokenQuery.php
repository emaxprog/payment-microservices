<?php
/**
 * Файл класса UserTokenQuery
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\scopes;

use chulakov\components\models\scopes\ActiveQuery;
use chulakov\components\models\scopes\QueryIdTrait;

class UserTokenQuery extends ActiveQuery
{
    use QueryIdTrait;

    /**
     * Поиск по пользователю
     *
     * @param integer $userId
     * @return static
     */
    public function byUserId($userId)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[user_id]]' => $userId]);
    }

    /**
     * Поиск модели токена через сам токен
     *
     * @param string $token
     * @return static
     */
    public function byToken($token)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[token]]' => $token]);
    }
}
