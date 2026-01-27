<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu_item_translation}}`.
 */
class m260118_120011_create_menu_item_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_item_translation}}', [
            'id' => $this->primaryKey(),
            'menu_item_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
        ]);

        $this->createIndex('idx-menu_item_translation-menu_item_id', '{{%menu_item_translation}}', 'menu_item_id');
        $this->createIndex('idx-menu_item_translation-language_id', '{{%menu_item_translation}}', 'language_id');
        $this->createIndex('idx-menu_item_translation-unique', '{{%menu_item_translation}}', ['menu_item_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-menu_item_translation-menu_item_id',
            '{{%menu_item_translation}}',
            'menu_item_id',
            '{{%menu_item}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item_translation-language_id',
            '{{%menu_item_translation}}',
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
        $this->dropForeignKey('fk-menu_item_translation-menu_item_id', '{{%menu_item_translation}}');
        $this->dropForeignKey('fk-menu_item_translation-language_id', '{{%menu_item_translation}}');
        $this->dropTable('{{%menu_item_translation}}');
    }
}
