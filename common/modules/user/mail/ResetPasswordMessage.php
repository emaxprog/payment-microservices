<?php
/**
 * Файл класса ResetPasswordMessage
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\mail;

use chulakov\components\mail\BaseMessage;

class ResetPasswordMessage extends BaseMessage
{
    /**
     * @var string Путь до html шаблона
     */
    protected $html = '@common/modules/user/mail/html/passwordResetToken';
    /**
     * @var string Путь до текстовой версии шаблона
     */
    protected $text = '@common/modules/user/mail/text/passwordResetToken';
    /**
     * @var string Тема сообщения
     */
    protected $subject = 'Password recovery information';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->subject = \Yii::t('ch/user', $this->subject);
    }
}
