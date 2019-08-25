<?php
/**
 * Файл класса Date
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\helpers;

/**
 * Хелпер форматирования даты
 *
 * @package common\helpers
 */
class Date
{
    /**
     * Дата в коротком формате: 12 марта.
     * Если год даты выходит за рамки текущего года, то добавляется в конце год: 12 марта 2017
     *
     * @param string|integer $date
     * @return string
     */
    public static function short($date)
    {
        $format = 'd MMMM';
        if (static::format($date, 'Y') != static::format(time(), 'Y')) {
            $format .= ' Y';
        }
        return static::format($date, $format);
    }

    /**
     * Форматирование даты в полном формате.
     * Пригоден для сохранения в базу данных как datetime или отправки по rest
     *
     * @param string|integer $date
     * @return string
     */
    public static function full($date)
    {
        return static::format($date, 'php:Y-m-d H:i:s');
    }

    /**
     * Пример возвращаемых форматов:
     *      24-26 JUNE
     *      24 JUNE - 26 JULE
     *      24 JUNE 2017 - 26 JULE 2018
     *
     * @param string|integer $from
     * @param string|integer $to
     * @return string
     */
    public static function period($from, $to = '')
    {
        // Отсутствует вторая дата
        if (empty($to)) {
            return static::short($from);
        }

        $t = html_entity_decode('&ndash;');
        list($fy, $fm, $fd) = explode('-', static::format($from, 'php:Y-F-j'));
        list($ty, $tm, $td) = explode('-', static::format($to, 'php:Y-F-j'));

        // Годы разные
        if ($fy != $ty) {
            return sprintf("%s %s %s {$t} %s %s %s", $fd, $fm, $fy, $td, $tm, $ty);
        }
        // Месяца разные
        if ($fm != $tm) {
            return sprintf("%s %s {$t} %s %s", $fd, $fm, $td, $tm);
        }
        // Один день
        if ($fd == $td) {
            return sprintf("%s %s", $fd, $fm);
        }
        // Месяца одинаковы
        return sprintf("%s{$t}%s %s", $fd, $td, $fm);
    }

    /**
     * Форматирование времени в формат стандартного вывода
     *
     * @param string|integer $date
     * @return string
     */
    public static function time($date)
    {
        return static::format($date, 'php:H:i:s');
    }

    /**
     * Форматирование даты в формат стандартного вывода
     *
     * @param string|integer $date
     * @return string
     */
    public static function date($date)
    {
        return static::format($date, 'php:d.m.Y');
    }

    /**
     * Форматирование даты и времени в формат стандартного вывода
     *
     * @param string|integer $date
     * @return string
     */
    public static function dateTime($date)
    {
        return static::format($date, 'php:d.m.Y H:i:s');
    }

    /**
     * Форматирование даты и времени в формат стандартного вывода
     *
     * @param string|integer $date
     * @return string
     */
    public static function timestamp($date)
    {
        // Корректное форматирование через Yii форматер
        try {
            return \Yii::$app->formatter->asTimestamp($date);
        } catch (\Exception $e) {
            \Yii::error($e);
        }
        if (is_string($date)) {
            $date = strtotime($date);
        }
        // Форматировение с игнорированием форматера...
        return $date;
    }

    /**
     * Форматирование даты
     *
     * @param string|integer $date
     * @param string $format
     * @return string
     */
    public static function format($date, $format)
    {
        // Корректное форматирование через Yii форматер
        try {
            return \Yii::$app->formatter->asDate($date, $format);
        } catch (\Exception $e) {
            \Yii::error($e);
        }
        // Форматировение с игнорированием форматера...
        if (is_string($date)) {
            $date = strtotime($date);
        }
        $format = (strpos('php:', $format) === 0)
            ? substr($format, 4) : 'H:i:s d.m.Y';
        return date($format, $date);
    }
}
