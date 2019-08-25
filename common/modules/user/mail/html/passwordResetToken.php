<?php
/**
 * Файл шаблона письма восстановления пароля
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var $this yii\web\View
 * @var $user \common\modules\user\models\User
 * @var string $url
 */

use yii\helpers\Html;

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->name) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($url), $url); ?></p>
</div>
