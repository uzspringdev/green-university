<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu_item".
 *
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property string|null $url
 * @property int $sort_order
 * @property int $status
 *
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $children
 * @property MenuItemTranslation[] $translations
 */
class MenuItem extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id'], 'required'],
            [['menu_id', 'parent_id', 'sort_order', 'status'], 'integer'],
            [['url'], 'string', 'max' => 500],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['sort_order'], 'default', 'value' => 0],
            [['status'], 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::class, 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItem::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu',
            'parent_id' => 'Parent Item',
            'url' => 'Url',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Menu]].
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::class, ['id' => 'menu_id']);
    }

    /**
     * Gets query for [[Parent]].
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Children]].
     */
    public function getChildren()
    {
        return $this->hasMany(MenuItem::class, ['parent_id' => 'id'])
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Gets query for [[AdminChildren]] (all children regardless of status).
     */
    public function getAdminChildren()
    {
        return $this->hasMany(MenuItem::class, ['parent_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(MenuItemTranslation::class, ['menu_item_id' => 'id']);
    }

    /**
     * Get translation for specific language with fallback
     */
    public function getTranslation($languageCode = null)
    {
        if ($languageCode === null) {
            $languageCode = Yii::$app->language;
        }

        $language = Language::findOne(['code' => $languageCode]);
        if ($language) {
            $translation = MenuItemTranslation::findOne([
                'menu_item_id' => $this->id,
                'language_id' => $language->id,
            ]);

            if ($translation && !empty($translation->title)) {
                return $translation;
            }
        }

        // Fallback to other languages if current language translation not found
        // Priority: en -> uz -> ru -> any available
        $fallbackCodes = ['en', 'uz', 'ru'];
        foreach ($fallbackCodes as $code) {
            if ($code === $languageCode)
                continue; // Skip already tried language

            $fallbackLang = Language::findOne(['code' => $code]);
            if ($fallbackLang) {
                $translation = MenuItemTranslation::findOne([
                    'menu_item_id' => $this->id,
                    'language_id' => $fallbackLang->id,
                ]);

                if ($translation && !empty($translation->title)) {
                    return $translation;
                }
            }
        }

        // Last resort: get any available translation
        $anyTranslation = MenuItemTranslation::find()
            ->where(['menu_item_id' => $this->id])
            ->andWhere(['not', ['title' => '']])
            ->one();

        return $anyTranslation;
    }

    /**
     * Check if item has children
     */
    public function hasChildren()
    {
        return $this->getChildren()->exists();
    }
}
