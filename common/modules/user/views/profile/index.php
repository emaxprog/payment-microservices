<?php
/**
 * Файл шаблона index
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\forms\AvatarForm $avatar
 * @var \common\modules\user\models\forms\ProfileForm $profile
 */

?>

<div class="row">
    <div class="col-md-4">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('ch/user', 'Avatar'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <?= $this->render('_avatar', [
                    'model' => $avatar,
                ]); ?>

            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('ch/user', 'Person data'); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <?= $this->render('_form', [
                    'model' => $profile,
                ]); ?>

            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> <?= Yii::t('ch/all', 'Update'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
