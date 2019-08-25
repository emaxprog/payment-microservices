<?php
/**
 * Файл класса CollectionHelper
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\helpers;

use yii\db\Query;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class CollectionHelper
{
    /**
     * Получение списка коллекции
     *
     * @param array|ActiveQuery|ActiveRecord|ActiveRecord[] $records
     * @param string $key
     * @param string $value
     * @return array
     */
    public static function getList($records, $key, $value)
    {
        $list = [];
        foreach (static::getIterable($records) as $item) {
            $list[ArrayHelper::getValue($item, $key)] = ArrayHelper::getValue($item, $value);
        }
        return $list;
    }

    /**
     * Получение именованного списка коллекции
     *
     * @param array|ActiveQuery|ActiveRecord|ActiveRecord[] $records
     * @param string $key
     * @param string $value
     * @return array
     */
    public static function getArray($records, $key, $value)
    {
        $list = [];
        foreach (static::getIterable($records) as $item) {
            $list[] = [
                $key => ArrayHelper::getValue($item, $key),
                $value => ArrayHelper::getValue($item, $value),
            ];
        }
        return $list;
    }

    /**
     * Преобразование коллекции в массив
     *
     * @param array|ActiveQuery|ActiveRecord|ActiveRecord[] $records
     * @return array
     */
    protected static function getIterable($records)
    {
        if ($records instanceof Query) {
            return $records->all();
        }
        if (!is_array($records)) {
            return [$records];
        }
        return $records;
    }
}
