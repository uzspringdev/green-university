<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page_translation".
 *
 * @property int $id
 * @property int $page_id
 * @property int $language_id
 * @property string $title
 * @property string|null $content
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 *
 * @property Page $page
 * @property Language $language
 */
class PageTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'language_id', 'title'], 'required'],
            [['page_id', 'language_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['meta_description', 'meta_keywords'], 'string', 'max' => 500],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['page_id' => 'id']],
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
            'page_id' => 'Page ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'content' => 'Content',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::class, ['id' => 'page_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
