<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "symbol".
 *
 * @property int $id
 * @property string|null $icon
 * @property string|null $value
 * @property int $sort_order
 * @property int $status
 *
 * @property SymbolTranslation[] $translations
 */
class Symbol extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'symbol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort_order', 'status'], 'integer'],
            [['icon', 'value'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['sort_order'], 'default', 'value' => 0],
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
            'icon' => 'Icon',
            'value' => 'Value',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(SymbolTranslation::class, ['symbol_id' => 'id']);
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

        return SymbolTranslation::findOne([
            'symbol_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * Get active symbols
     */
    public static function findActive()
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC]);
    }
}
