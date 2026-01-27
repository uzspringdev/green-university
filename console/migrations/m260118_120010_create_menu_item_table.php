<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu_item}}`.
 */
class m260118_120010_create_menu_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_item}}', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'url' => $this->string(255),
            'page_id' => $this->integer(),
            'news_category_id' => $this->integer(),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-menu_item-menu_id', '{{%menu_item}}', 'menu_id');
        $this->createIndex('idx-menu_item-parent_id', '{{%menu_item}}', 'parent_id');
        $this->createIndex('idx-menu_item-page_id', '{{%menu_item}}', 'page_id');
        $this->createIndex('idx-menu_item-status', '{{%menu_item}}', 'status');

        $this->addForeignKey(
            'fk-menu_item-menu_id',
            '{{%menu_item}}',
            'menu_id',
            '{{%menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item-parent_id',
            '{{%menu_item}}',
            'parent_id',
            '{{%menu_item}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item-page_id',
            '{{%menu_item}}',
            'page_id',
            '{{%page}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-menu_item-news_category_id',
            '{{%menu_item}}',
            'news_category_id',
            '{{%news_category}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-menu_item-menu_id', '{{%menu_item}}');
        $this->dropForeignKey('fk-menu_item-parent_id', '{{%menu_item}}');
        $this->dropForeignKey('fk-menu_item-page_id', '{{%menu_item}}');
        $this->dropForeignKey('fk-menu_item-news_category_id', '{{%menu_item}}');
        $this->dropTable('{{%menu_item}}');
    }
}
