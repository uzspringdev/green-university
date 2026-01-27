<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news_category".
 *
 * @property int $id
 * @property string $slug
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property NewsCategoryTranslation[] $translations
 * @property News[] $news
 */
class NewsCategory extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_category';
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
            [['slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status'], 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
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
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(NewsCategoryTranslation::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[News]].
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['category_id' => 'id']);
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

        return NewsCategoryTranslation::findOne([
            'category_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * Get active categories
     */
    public static function findActive()
    {
        return static::find()->where(['status' => self::STATUS_ACTIVE]);
    }
}
