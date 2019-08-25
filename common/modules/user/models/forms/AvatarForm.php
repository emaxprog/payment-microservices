<?php
/**
 * Файл класса UploadForm
 *
 * @copyright Copyright (c) 2018, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace common\modules\user\models\forms;

use yii\base\Model;
use yii\helpers\Url;
use chulakov\filestorage\models\Image;
use chulakov\filestorage\uploaders\UploadInterface;
use chulakov\filestorage\behaviors\FileUploadBehavior;
use chulakov\components\behaviors\FileOwnerBehavior;
use common\modules\user\models\User;

/**
 * Форма загрузки аватара.
 *
 * @mixin FileUploadBehavior
 * @mixin FileOwnerBehavior
 */
class AvatarForm extends Model
{
    /**
     * @var UploadInterface Загружаемое изображение
     */
    public $file;
    /**
     * @var Image
     */
    public $fileAttached;

    /**
     * @var User
     */
    protected $model;

    /**
     * Контсруктор формы загрузки аватара
     *
     * @param User $model
     * @param array $config
     */
    public function __construct(User $model, array $config = [])
    {
        $this->model = $model;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->fileAttached = $this->model->avatar;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => FileUploadBehavior::class,
                'attribute' => 'file',
                'group' => User::UPLOAD_GROUP,
            ],
            [
                'class' => FileOwnerBehavior::class,
                'property' => function() {
                    return $this->model->id;
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            ['file', 'file', 'mimeTypes' => ['image/*'], 'maxSize' => 5120000],
        ];
    }

    /**
     * Подготовка данных для предпросмотра
     *
     * @return array
     */
    public function getInitialPreview()
    {
        $preview = [];
        if (!empty($this->fileAttached)) {
            $preview[] = $this->fileAttached->getUrl();
        }
        return $preview;
    }

    /**
     * Подготовка конфигурации ранее загруженного файла
     *
     * @return array
     */
    public function getInitialPreviewConfig()
    {
        $config = [];
        if (!empty($this->fileAttached)) {
            $config[] = [
                'caption' => $this->fileAttached->ori_name,
                'filetype' => $this->fileAttached->mime,
                'size' => $this->fileAttached->size,
                'extra' => ['id' => $this->fileAttached->id],
                'url' => Url::to(['remove']),
                'width' => '213px',
            ];
        }
        return $config;
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }
}
