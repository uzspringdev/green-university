<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%page}}`.
 */
class m260118_120001_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-page-status', '{{%page}}', 'status');
        $this->createIndex('idx-page-slug', '{{%page}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
