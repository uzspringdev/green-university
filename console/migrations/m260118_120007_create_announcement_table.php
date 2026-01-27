<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%announcement}}`.
 */
class m260118_120007_create_announcement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%announcement}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->unique(),
            'announcement_type' => $this->string(50)->defaultValue('info'),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date(),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-announcement-status', '{{%announcement}}', 'status');
        $this->createIndex('idx-announcement-type', '{{%announcement}}', 'announcement_type');
        $this->createIndex('idx-announcement-dates', '{{%announcement}}', ['start_date', 'end_date']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%announcement}}');
    }
}
