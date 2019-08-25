<?php
/**
 * Файл шаблона _avatar
 *
 * @copyright Copyright (c) 2019, Oleg Chulakov Studio
 * @link http://chulakov.com/
 *
 * @var \yii\web\View $this
 * @var \common\modules\user\models\forms\AvatarForm $model
 */

use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\file\FileInput;

?>

<?= FileInput::widget([
    'name' => 'file',
    'sortThumbs' => false,
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'initialPreview' => $model->getInitialPreview(),
        'initialPreviewConfig' => $model->getInitialPreviewConfig(),
        'initialPreviewAsData' => true,
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'showClose' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' =>  Yii::t('ch/user', 'Select Photo'),
        'uploadAsync' => true,
        'uploadUrl' => Url::to(['upload']),
        'deleteUrl' => Url::to(['remove']),
        'maxFileSize' => 5120,
        'fileActionSettings' => [
            'showDrag' => false,
        ],
    ],
    'pluginEvents' => [
        'filebatchselected' => new JsExpression(
            'function() {$(this).fileinput("upload");}'
        ),
    ],
]); ?>

<?php
$css = <<<CSS
.file-drop-zone, .file-preview {
    border: none;
}
.file-preview-thumbnails {
    display: inline-block;
}
CSS;
$this->registerCss($css);
