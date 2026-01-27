<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "footer_block".
 *
 * @property int $id
 * @property int $column_position
 * @property int $sort_order
 * @property int $status
 *
 * @property FooterBlockTranslation[] $translations
 */
class FooterBlock extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'footer_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['column_position'], 'integer'],
            [['sort_order'], 'integer'],
            [['status'], 'integer'],
            [['column_position'], 'default', 'value' => 1],
            [['sort_order'], 'default', 'value' => 0],
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
            'column_position' => 'Column Position',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Translations]].
     */
    public function getTranslations()
    {
        return $this->hasMany(FooterBlockTranslation::class, ['footer_block_id' => 'id']);
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

        return FooterBlockTranslation::findOne([
            'footer_block_id' => $this->id,
            'language_id' => $language->id,
        ]);
    }

    /**
     * Get footer blocks by column position
     */
    public static function findByColumn($columnPosition)
    {
        return static::find()
            ->where(['column_position' => $columnPosition, 'status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }
}
