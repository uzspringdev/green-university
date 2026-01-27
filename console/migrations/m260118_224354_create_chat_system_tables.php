<?php

use yii\db\Migration;

class m260118_224354_create_chat_system_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // Drop old table if exists
        if ($this->db->getTableSchema('{{%message}}', true) !== null) {
            $this->dropTable('{{%message}}');
        }

        // 1. Chat Conversations
        $this->createTable('{{%chat_conversations}}', [
            'id' => $this->primaryKey(),
            'type' => $this->tinyInteger()->notNull()->defaultValue(1)->comment('1:private, 2:group'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        // 2. Chat Participants
        $this->createTable('{{%chat_participants}}', [
            'id' => $this->primaryKey(),
            'conversation_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'joined_at' => $this->integer(),
        ], $tableOptions);

        // Indexes & FKs for Participants
        $this->createIndex('{{%idx-chat_participants-conversation_id}}', '{{%chat_participants}}', 'conversation_id');
        $this->createIndex('{{%idx-chat_participants-user_id}}', '{{%chat_participants}}', 'user_id');

        $this->addForeignKey('{{%fk-chat_participants-conversation_id}}', '{{%chat_participants}}', 'conversation_id', '{{%chat_conversations}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-chat_participants-user_id}}', '{{%chat_participants}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // 3. Chat Messages
        $this->createTable('{{%chat_messages}}', [
            'id' => $this->primaryKey(),
            'conversation_id' => $this->integer()->notNull(),
            'sender_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'is_read' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
        ], $tableOptions);

        // Indexes & FKs for Messages
        $this->createIndex('{{%idx-chat_messages-conversation_id}}', '{{%chat_messages}}', 'conversation_id');
        $this->addForeignKey('{{%fk-chat_messages-conversation_id}}', '{{%chat_messages}}', 'conversation_id', '{{%chat_conversations}}', 'id', 'CASCADE');
        $this->addForeignKey('{{%fk-chat_messages-sender_id}}', '{{%chat_messages}}', 'sender_id', '{{%user}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%chat_messages}}');
        $this->dropTable('{{%chat_participants}}');
        $this->dropTable('{{%chat_conversations}}');

        // Recreate old table
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer()->notNull(),
            'receiver_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'is_read' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260118_224354_create_chat_system_tables cannot be reverted.\n";

        return false;
    }
    */
}
