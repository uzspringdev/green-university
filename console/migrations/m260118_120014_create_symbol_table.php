<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%symbol}}`.
 */
class m260118_120014_create_symbol_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%symbol}}', [
            'id' => $this->primaryKey(),
            'icon' => $this->string(100),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-symbol-status', '{{%symbol}}', 'status');
        $this->createIndex('idx-symbol-sort_order', '{{%symbol}}', 'sort_order');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%symbol}}');
    }
}
