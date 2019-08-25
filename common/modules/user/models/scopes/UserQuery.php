<?php
/**
 * Файл класса UserQuery
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\scopes;

use chulakov\components\models\scopes\ActiveQuery;
use chulakov\components\models\scopes\QueryIdTrait;

class UserQuery extends ActiveQuery
{
    use QueryIdTrait;

    /**
     * Поиск по логину
     *
     * @param string $username
     * @return static
     */
    public function byUsername($username)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[username]]' => $username]);
    }

    /**
     * Поиск по e-mail адресу
     *
     * @param string $email
     * @return static
     */
    public function byEmail($email)
    {
        return $this->andWhere([$this->getPrimaryTableName() . '.[[email]]' => $email]);
    }

    /**
     * Поиск по токену запросов
     *
     * @param string $type
     * @param string $token
     * @return static
     */
    public function byRequestToken($type, $token)
    {
        return $this
            ->joinWith('requests as request', true, 'INNER JOIN')
            ->andWhere([
                'request.type' => $type,
                'request.token' => $token,
            ]);
    }
}
