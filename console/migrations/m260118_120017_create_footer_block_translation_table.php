<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%footer_block_translation}}`.
 */
class m260118_120017_create_footer_block_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%footer_block_translation}}', [
            'id' => $this->primaryKey(),
            'footer_block_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'content' => $this->text(),
        ]);

        $this->createIndex('idx-footer_block_translation-footer_block_id', '{{%footer_block_translation}}', 'footer_block_id');
        $this->createIndex('idx-footer_block_translation-language_id', '{{%footer_block_translation}}', 'language_id');
        $this->createIndex('idx-footer_block_translation-unique', '{{%footer_block_translation}}', ['footer_block_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-footer_block_translation-footer_block_id',
            '{{%footer_block_translation}}',
            'footer_block_id',
            '{{%footer_block}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-footer_block_translation-language_id',
            '{{%footer_block_translation}}',
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
        $this->dropForeignKey('fk-footer_block_translation-footer_block_id', '{{%footer_block_translation}}');
        $this->dropForeignKey('fk-footer_block_translation-language_id', '{{%footer_block_translation}}');
        $this->dropTable('{{%footer_block_translation}}');
    }
}
