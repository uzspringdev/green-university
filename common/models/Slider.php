<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $link_url
 * @property int $sort_order
 * @property int $status
 *
 * @property SliderTranslation[] $translations
 */
class Slider extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort_order', 'status'], 'integer'],
            [['image', 'link_url'], 'string', 'max' => 500],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['sort_order'], 'default', 'value' => 0],
            [['status'], 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'link_url' => 'Link Url',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(SliderTranslation::class, ['slider_id' => 'id']);
    }

    /**
     * Get translation for specific language
     */
    public function getTranslation($languageCode = null)
    {
        if ($languageCode === null) {
            $languageCode = Yii::$app->language;
        }

        $language = Language::findOne(['code' => $languageCode]);
        if (!$language) {
            return null;
        }

        return SliderTranslation::findOne([
            'slider_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * Upload image
     */
    public function upload()
    {
        if ($this->validate() && $this->imageFile) {
            $filename = time() . '_' . uniqid() . '.' . $this->imageFile->extension;
            $path = Yii::getAlias('@frontend/web/uploads/slider/');

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            if ($this->imageFile->saveAs($path . $filename)) {
                $this->image = $filename;
                return true;
            }
        }
        return false;
    }

    /**
     * Get image URL
     */
    public function getImageUrl()
    {
        if ($this->image) {
            $path = '/uploads/slider/' . $this->image;
            if (Yii::$app->id === 'app-backend') {
                return Yii::getAlias('@frontendUrl' . $path);
            }
            return Yii::getAlias('@web' . $path);
        }
        return null;
    }

    /**
     * Get active slides
     */
    public static function findActive()
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC]);
    }
}
