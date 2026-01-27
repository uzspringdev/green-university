<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%symbol_translation}}`.
 */
class m260118_120015_create_symbol_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%symbol_translation}}', [
            'id' => $this->primaryKey(),
            'symbol_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
        ]);

        $this->createIndex('idx-symbol_translation-symbol_id', '{{%symbol_translation}}', 'symbol_id');
        $this->createIndex('idx-symbol_translation-language_id', '{{%symbol_translation}}', 'language_id');
        $this->createIndex('idx-symbol_translation-unique', '{{%symbol_translation}}', ['symbol_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-symbol_translation-symbol_id',
            '{{%symbol_translation}}',
            'symbol_id',
            '{{%symbol}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-symbol_translation-language_id',
            '{{%symbol_translation}}',
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
        $this->dropForeignKey('fk-symbol_translation-symbol_id', '{{%symbol_translation}}');
        $this->dropForeignKey('fk-symbol_translation-language_id', '{{%symbol_translation}}');
        $this->dropTable('{{%symbol_translation}}');
    }
}
