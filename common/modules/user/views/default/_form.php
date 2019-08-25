<?php
/**
 * Файл шаблона формы
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\forms\UserForm $model
 * @var \yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model, [
    'class' => 'alert alert-error'
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
