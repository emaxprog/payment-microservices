<?php
/**
 * Файл класса Random
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\helpers;

/**
 * Class Random
 * @package common\helpers
 */
class Random
{
    /**
     * Basic авторизация
     * @param int $min
     * @param int $max
     * @param int $decimals
     * @return float|int
     */
    public static function floatRand($min, $max, $decimals = 0)
    {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}