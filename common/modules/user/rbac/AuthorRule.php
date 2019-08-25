<?php
/**
 * Файл класса AuthorRule
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\rbac;

use yii\rbac\Item;
use yii\rbac\Rule;
use yii\db\ActiveRecord;

class AuthorRule extends Rule
{
    /**
     * Выполнение проверки.
     * Требуется передавать модели для проверки авторства.
     * Принимает два параметра:
     *
     * 'model' = ActiveRecord модель для проверки авторства
     * 'attribute' = название свойства в модели, по умолчанию используется create_by
     *
     * Использование:
     *
     * ```php
     * if (!\Yii::$app->user->can('updateOwnPost', ['model' => $model, 'attribute' => 'author_id'])) {
     *     throw new ForbiddenHttpException('Access denied');
     * }
     * ```
     *
     * @param string|int $user
     * @param Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var ActiveRecord $model */
            $model = $params['model'];
            $attribute = isset($params['attribute']) ? $params['attribute'] : 'created_by';
            if ($model->hasAttribute($attribute)) {
                return $user == $model->getAttribute($attribute);
            }
        }
        return false;
    }
}
