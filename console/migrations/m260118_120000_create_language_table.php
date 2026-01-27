<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m260118_120000_create_language_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5)->notNull()->unique(),
            'name' => $this->string(50)->notNull(),
            'is_default' => $this->boolean()->defaultValue(false),
            'status' => $this->smallInteger()->defaultValue(1),
            'sort_order' => $this->integer()->defaultValue(0),
        ]);

        // Insert default languages
        $this->batchInsert('{{%language}}', ['code', 'name', 'is_default', 'status', 'sort_order'], [
            ['uz', 'O\'zbekcha', true, 1, 1],
            ['en', 'English', false, 1, 2],
            ['ru', 'Русский', false, 1, 3],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
