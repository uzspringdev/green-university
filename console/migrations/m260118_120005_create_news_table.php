<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m260118_120005_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'slug' => $this->string(255)->notNull()->unique(),
            'image' => $this->string(255),
            'views' => $this->integer()->defaultValue(0),
            'is_featured' => $this->boolean()->defaultValue(false),
            'status' => $this->smallInteger()->defaultValue(0),
            'published_at' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-news-category_id', '{{%news}}', 'category_id');
        $this->createIndex('idx-news-status', '{{%news}}', 'status');
        $this->createIndex('idx-news-is_featured', '{{%news}}', 'is_featured');
        $this->createIndex('idx-news-published_at', '{{%news}}', 'published_at');

        $this->addForeignKey(
            'fk-news-category_id',
            '{{%news}}',
            'category_id',
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
        $this->dropForeignKey('fk-news-category_id', '{{%news}}');
        $this->dropTable('{{%news}}');
    }
}
