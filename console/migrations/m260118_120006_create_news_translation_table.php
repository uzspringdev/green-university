<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_translation}}`.
 */
class m260118_120006_create_news_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_translation}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'summary' => $this->text(),
            'content' => $this->text(),
            'meta_description' => $this->text(),
        ]);

        $this->createIndex('idx-news_translation-news_id', '{{%news_translation}}', 'news_id');
        $this->createIndex('idx-news_translation-language_id', '{{%news_translation}}', 'language_id');
        $this->createIndex('idx-news_translation-unique', '{{%news_translation}}', ['news_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-news_translation-news_id',
            '{{%news_translation}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_translation-language_id',
            '{{%news_translation}}',
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
        $this->dropForeignKey('fk-news_translation-news_id', '{{%news_translation}}');
        $this->dropForeignKey('fk-news_translation-language_id', '{{%news_translation}}');
        $this->dropTable('{{%news_translation}}');
    }
}
