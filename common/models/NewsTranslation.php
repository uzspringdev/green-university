<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_translation".
 *
 * @property int $id
 * @property int $news_id
 * @property int $language_id
 * @property string $title
 * @property string|null $summary
 * @property string|null $content
 *
 * @property News $news
 * @property Language $language
 */
class NewsTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'language_id', 'title'], 'required'],
            [['news_id', 'language_id'], 'integer'],
            [['content', 'summary'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
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
            'news_id' => 'News ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[News]].
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
