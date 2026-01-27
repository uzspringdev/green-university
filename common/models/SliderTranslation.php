<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "slider_translation".
 *
 * @property int $id
 * @property int $slider_id
 * @property int $language_id
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $link_text
 *
 * @property Slider $slider
 * @property Language $language
 */
class SliderTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slider_id', 'language_id'], 'required'],
            [['slider_id', 'language_id'], 'integer'],
            [['title', 'subtitle', 'link_text'], 'string', 'max' => 255],
            [['slider_id'], 'exist', 'skipOnError' => true, 'targetClass' => Slider::class, 'targetAttribute' => ['slider_id' => 'id']],
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
            'slider_id' => 'Slider ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'link_text' => 'Link Text',
        ];
    }

    /**
     * Gets query for [[Slider]].
     */
    public function getSlider()
    {
        return $this->hasOne(Slider::class, ['id' => 'slider_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
