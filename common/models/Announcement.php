<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "announcement".
 *
 * @property int $id
 * @property string $slug
 * @property string|null $image
 * @property int $status
 * @property int|null $published_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AnnouncementTranslation[] $translations
 */
class Announcement extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['status'], 'integer'],
            [['published_at'], 'safe'], // Allow both string and integer, conversion happens in beforeValidate()
            [['slug'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_DRAFT],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp', 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'image' => 'Image',
            'status' => 'Status',
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(AnnouncementTranslation::class, ['announcement_id' => 'id']);
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

        return AnnouncementTranslation::findOne([
            'announcement_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            // Convert published_at to timestamp if it's a date string
            if ($this->published_at && !is_numeric($this->published_at)) {
                $this->published_at = strtotime($this->published_at);
            }
            return true;
        }
        return false;
    }

    /**
     * Upload image
     */
    public function upload()
    {
        if ($this->validate() && $this->imageFile) {
            $filename = time() . '_' . uniqid() . '.' . $this->imageFile->extension;
            $path = Yii::getAlias('@frontend/web/uploads/announcements/');

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
            $path = '/uploads/announcements/' . $this->image;
            if (Yii::$app->id === 'app-backend') {
                return Yii::getAlias('@frontendUrl' . $path);
            }
            return Yii::getAlias('@web' . $path);
        }
        return null;
    }

    /**
     * Get published announcements
     */
    public static function findPublished()
    {
        $query = static::find()
            ->where(['announcement.status' => self::STATUS_PUBLISHED])
            ->andWhere(['<=', 'announcement.published_at', time()])
            ->orderBy(['announcement.published_at' => SORT_DESC]);

        // Filter by current active language translation availability
        $langCode = Yii::$app->language;
        $language = Language::findOne(['code' => $langCode]);

        if ($language) {
            $query->innerJoinWith([
                'translations' => function ($q) use ($language) {
                    $q->where(['language_id' => $language->id])
                        ->andWhere(['!=', 'title', '']);
                }
            ]);
        }

        return $query;
    }
}
