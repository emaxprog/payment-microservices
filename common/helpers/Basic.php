<?php
/**
 * Файл класса Basic
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\helpers;

/**
 * Класс хелпер для работы с Basic авторизацией
 * @package common\helpers
 */
class Basic
{
    /**
     * Basic авторизация
     */
    public static function auth()
    {
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != getenv('basic_login') ||
            $_SERVER['PHP_AUTH_PW'] != getenv('basic_password')
        );
        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }
    }
}