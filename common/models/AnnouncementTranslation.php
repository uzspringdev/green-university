<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "announcement_translation".
 *
 * @property int $id
 * @property int $announcement_id
 * @property int $language_id
 * @property string $title
 * @property string|null $content
 *
 * @property Announcement $announcement
 * @property Language $language
 */
class AnnouncementTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['announcement_id', 'language_id', 'title'], 'required'],
            [['announcement_id', 'language_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['announcement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Announcement::class, 'targetAttribute' => ['announcement_id' => 'id']],
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
            'announcement_id' => 'Announcement ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Announcement]].
     */
    public function getAnnouncement()
    {
        return $this->hasOne(Announcement::class, ['id' => 'announcement_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
