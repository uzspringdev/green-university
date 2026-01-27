<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_category}}`.
 */
class m260118_120003_create_news_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'status' => $this->smallInteger()->defaultValue(1),
            'sort_order' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex('idx-news_category-status', '{{%news_category}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_category}}');
    }
}
