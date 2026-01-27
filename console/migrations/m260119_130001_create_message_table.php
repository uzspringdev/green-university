<?php

use yii\db\Migration;

/**
 * Class m260119_130001_create_message_table
 */
class m260119_130001_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer()->notNull(),
            'receiver_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'is_read' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
        ]);

        // Index for sender_id
        $this->createIndex(
            '{{%idx-message-sender_id}}',
            '{{%message}}',
            'sender_id'
        );

        // Foreign key for sender_id
        $this->addForeignKey(
            '{{%fk-message-sender_id}}',
            '{{%message}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Index for receiver_id
        $this->createIndex(
            '{{%idx-message-receiver_id}}',
            '{{%message}}',
            'receiver_id'
        );

        // Foreign key for receiver_id
        $this->addForeignKey(
            '{{%fk-message-receiver_id}}',
            '{{%message}}',
            'receiver_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys first
        $this->dropForeignKey('{{%fk-message-sender_id}}', '{{%message}}');
        $this->dropForeignKey('{{%fk-message-receiver_id}}', '{{%message}}');

        // Drop indexes
        $this->dropIndex('{{%idx-message-sender_id}}', '{{%message}}');
        $this->dropIndex('{{%idx-message-receiver_id}}', '{{%message}}');

        $this->dropTable('{{%message}}');
    }
}
