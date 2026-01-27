<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "footer_block_translation".
 *
 * @property int $id
 * @property int $footer_block_id
 * @property int $language_id
 * @property string|null $title
 * @property string|null $content
 *
 * @property FooterBlock $footerBlock
 * @property Language $language
 */
class FooterBlockTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'footer_block_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['footer_block_id', 'language_id'], 'required'],
            [['footer_block_id', 'language_id'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['footer_block_id'], 'exist', 'skipOnError' => true, 'targetClass' => FooterBlock::class, 'targetAttribute' => ['footer_block_id' => 'id']],
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
            'footer_block_id' => 'Footer Block ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[FooterBlock]].
     */
    public function getFooterBlock()
    {
        return $this->hasOne(FooterBlock::class, ['id' => 'footer_block_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
