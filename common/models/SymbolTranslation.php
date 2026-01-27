<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "symbol_translation".
 *
 * @property int $id
 * @property int $symbol_id
 * @property int $language_id
 * @property string|null $title
 * @property string|null $description
 *
 * @property Symbol $symbol
 * @property Language $language
 */
class SymbolTranslation extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'symbol_translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol_id', 'language_id'], 'required'],
            [['symbol_id', 'language_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['symbol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Symbol::class, 'targetAttribute' => ['symbol_id' => 'id']],
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
            'symbol_id' => 'Symbol ID',
            'language_id' => 'Language',
            'title' => 'Title',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Symbol]].
     */
    public function getSymbol()
    {
        return $this->hasOne(Symbol::class, ['id' => 'symbol_id']);
    }

    /**
     * Gets query for [[Language]].
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }
}
