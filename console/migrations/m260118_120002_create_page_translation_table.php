<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page_translation}}`.
 */
class m260118_120002_create_page_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_translation}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
            'meta_description' => $this->text(),
            'meta_keywords' => $this->string(255),
        ]);

        $this->createIndex('idx-page_translation-page_id', '{{%page_translation}}', 'page_id');
        $this->createIndex('idx-page_translation-language_id', '{{%page_translation}}', 'language_id');
        $this->createIndex('idx-page_translation-unique', '{{%page_translation}}', ['page_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-page_translation-page_id',
            '{{%page_translation}}',
            'page_id',
            '{{%page}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-page_translation-language_id',
            '{{%page_translation}}',
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
        $this->dropForeignKey('fk-page_translation-page_id', '{{%page_translation}}');
        $this->dropForeignKey('fk-page_translation-language_id', '{{%page_translation}}');
        $this->dropTable('{{%page_translation}}');
    }
}
