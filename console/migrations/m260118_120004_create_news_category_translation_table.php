<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_category_translation}}`.
 */
class m260118_120004_create_news_category_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_category_translation}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
        ]);

        $this->createIndex('idx-news_category_translation-category_id', '{{%news_category_translation}}', 'category_id');
        $this->createIndex('idx-news_category_translation-language_id', '{{%news_category_translation}}', 'language_id');
        $this->createIndex('idx-news_category_translation-unique', '{{%news_category_translation}}', ['category_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-news_category_translation-category_id',
            '{{%news_category_translation}}',
            'category_id',
            '{{%news_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_category_translation-language_id',
            '{{%news_category_translation}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-news_category_translation-category_id', '{{%news_category_translation}}');
        $this->dropForeignKey('fk-news_category_translation-language_id', '{{%news_category_translation}}');
        $this->dropTable('{{%news_category_translation}}');
    }
}
