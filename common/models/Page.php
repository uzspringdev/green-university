<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $slug
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PageTranslation[] $translations
 */
class Page extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
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
     * Gets query for [[PageTranslation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(PageTranslation::class, ['page_id' => 'id']);
    }

    /**
     * Get translation for specific language
     * 
     * @param string $languageCode
     * @return PageTranslation|null
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

        return PageTranslation::findOne([
            'page_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * Get status label
     * 
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->status === self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    /**
     * Get active pages
     * 
     * @return \yii\db\ActiveQuery
     */
    public static function findActive()
    {
        $query = static::find()->where(['page.status' => self::STATUS_ACTIVE]);

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
