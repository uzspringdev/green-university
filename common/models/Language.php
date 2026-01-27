<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property bool|null $is_default
 * @property int|null $status
 * @property int|null $sort_order
 */
class Language extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['is_default'], 'boolean'],
            [['status', 'sort_order'], 'integer'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 50],
            [['code'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['sort_order'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'is_default' => 'Is Default',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
        ];
    }

    /**
     * Get active languages
     */
    public static function getActiveLanguages()
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }

    /**
     * Get default language
     */
    public static function getDefaultLanguage()
    {
        return static::findOne(['is_default' => true, 'status' => self::STATUS_ACTIVE]);
    }
}
