<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_item_translation".
 *
 * @property int $id
 * @property int $menu_item_id
 * @property int $language_id
 * @property string $title
 *
 * @property MenuItem $menuItem
 * @property Language $language
 */
class MenuItemTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_item_id', 'language_id', 'title'], 'required'],
            [['menu_item_id', 'language_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['menu_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::class, 'targetAttribute' => ['menu_item_id' => 'id']],
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
            'menu_item_id' => 'Menu Item ID',
            'language_id' => 'Language',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[MenuItem]].
     */
    public function getMenuItem()
    {
        return $this->hasOne(MenuItem::class, ['id' => 'menu_item_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
