<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_log}}`.
 */
class m260118_200000_create_admin_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'action' => $this->string(50)->notNull(),
            'model' => $this->string(100),
            'model_id' => $this->integer(),
            'description' => $this->text(),
            'ip_address' => $this->string(45),
            'user_agent' => $this->text(),
            'created_at' => $this->integer()->notNull(),
        ]);

        // Indexes
        $this->createIndex('idx-admin_log-user_id', '{{%admin_log}}', 'user_id');
        $this->createIndex('idx-admin_log-action', '{{%admin_log}}', 'action');
        $this->createIndex('idx-admin_log-model', '{{%admin_log}}', 'model');
        $this->createIndex('idx-admin_log-created_at', '{{%admin_log}}', 'created_at');

        // Foreign Key
        $this->addForeignKey(
            'fk-admin_log-user_id',
            '{{%admin_log}}',
            'user_id',
            '{{%user}}',
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
        $this->dropForeignKey('fk-admin_log-user_id', '{{%admin_log}}');
        $this->dropTable('{{%admin_log}}');
    }
}
