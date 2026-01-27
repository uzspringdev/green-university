<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%announcement_translation}}`.
 */
class m260118_120008_create_announcement_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%announcement_translation}}', [
            'id' => $this->primaryKey(),
            'announcement_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'content' => $this->text(),
        ]);

        $this->createIndex('idx-announcement_translation-announcement_id', '{{%announcement_translation}}', 'announcement_id');
        $this->createIndex('idx-announcement_translation-language_id', '{{%announcement_translation}}', 'language_id');
        $this->createIndex('idx-announcement_translation-unique', '{{%announcement_translation}}', ['announcement_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-announcement_translation-announcement_id',
            '{{%announcement_translation}}',
            'announcement_id',
            '{{%announcement}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-announcement_translation-language_id',
            '{{%announcement_translation}}',
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
        $this->dropForeignKey('fk-announcement_translation-announcement_id', '{{%announcement_translation}}');
        $this->dropForeignKey('fk-announcement_translation-language_id', '{{%announcement_translation}}');
        $this->dropTable('{{%announcement_translation}}');
    }
}
