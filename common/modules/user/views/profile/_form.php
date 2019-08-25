<?php
/**
 * Файл шаблона _form
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View
 * @var \common\modules\user\models\forms\ProfileForm $model
 */

use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h4><?= Yii::t('ch/user', 'Change password'); ?></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'password')->textInput(); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'confirm')->textInput(); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
