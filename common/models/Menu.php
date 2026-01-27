<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $code
 * @property int $status
 *
 * @property MenuItem[] $menuItems
 */
class Menu extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 50],
            [['code'], 'unique'],
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
            'code' => 'Code',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[MenuItems]].
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id'])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Get root menu items (items without parent)
     */
    public function getRootItems()
    {
        return $this->hasMany(MenuItem::class, ['menu_id' => 'id'])
            ->where(['parent_id' => null])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    /**
     * Get menu by code
     */
    public static function findByCode($code)
    {
        return static::findOne(['code' => $code, 'status' => self::STATUS_ACTIVE]);
    }
}
