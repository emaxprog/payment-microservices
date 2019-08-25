<?php

namespace common\messages;

use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Компонент получения перевода из модулей.
 * Основан на PHP источнике переводов с изменением соглашения об именовании файлов.
 *
 * Токен перевода может состоять из трех и более частей, разделенных символом /:
 * - одна часть или modules:
 *      перевод распологается по пути: $basePath . $modules . messages/ru/translate.php
 * - две части или trigger/modules:
 *      ничем не отличается от предыдущего варианта за исключением наличия тригера
 *      распознавания источника языкового файла.
 * - три и более частей или trigger/modules/name/...:
 *      тригерная часть отсекается, она используется для поиска источника.
 *      третья часть используется для поиска имени файла перевода, например в карте файлов.
 *      итоговый путь файла: $basePath . $modules . messages/ru . name .php
 *
 * Примеры:
 *
 * При наличии настройки перевода:
 * 'i18n' => [
 *     'translations' => [
 *         'trigger*' => [
 *             'class' => 'common\messages\ModulesSource',
 *             'basePath' => '@common/modules',
 *             'sourceLanguage' => 'en-US',
 *         ],
 *     ],
 * ],
 *
 * Будет обратывать все запросы типа:
 *   trigger/pages             - common/modules/pages/messages/ru/translate.php
 *   trigger/pages/name        - common/modules/pages/messages/ru/name.php
 *   trigger/pages/sub/name    - common/modules/pages/messages/ru/sub/name.php
 *
 * @package common\messages
 */
class ModulesSource extends PhpMessageSource
{
    /**
     * @var string
     */
    public $basePath = '@common/modules';

    /**
     * Возвращает путь до файла согласно соглашению о расположении файлов
     *
     * @param string $category
     * @param string $language
     * @return string
     */
    protected function getMessageFilePath($category, $language)
    {
        $module = $category;
        $name = 'translate';

        $parts = explode('/', str_replace('\\', '/', $category), 3);
        switch (count($parts)) {
            case 3:
                list($trigger, $module, $name) = $parts;
                break;
            case 2:
                list($trigger, $module) = $parts;
                break;
        }

        $messageFile = Yii::getAlias($this->basePath) . "/{$module}/messages/{$language}/";
        if (isset($this->fileMap[$name])) {
            $messageFile .= $this->fileMap[$name];
        } else {
            $messageFile .= $name . '.php';
        }

        return $messageFile;
    }
}
