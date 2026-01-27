<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m260118_120018_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'email' => $this->string(255)->notNull(),
            'phone' => $this->string(20)->notNull(),
            'program' => $this->string(255),
            'message' => $this->text(),
            'status' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-application-status', '{{%application}}', 'status');
        $this->createIndex('idx-application-email', '{{%application}}', 'email');
        $this->createIndex('idx-application-created_at', '{{%application}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application}}');
    }
}
