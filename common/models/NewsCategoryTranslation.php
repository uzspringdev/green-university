<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_category_translation".
 *
 * @property int $id
 * @property int $category_id
 * @property int $language_id
 * @property string $name
 *
 * @property NewsCategory $newsCategory
 * @property Language $language
 */
class NewsCategoryTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_category_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'language_id', 'name'], 'required'],
            [['category_id', 'language_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'News Category ID',
            'language_id' => 'Language',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[NewsCategory]].
     */
    public function getNewsCategory()
    {
        return $this->hasOne(NewsCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
