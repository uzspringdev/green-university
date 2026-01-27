<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%footer_block}}`.
 */
class m260118_120016_create_footer_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%footer_block}}', [
            'id' => $this->primaryKey(),
            'column_position' => $this->smallInteger()->defaultValue(1),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
        ]);

        $this->createIndex('idx-footer_block-column_position', '{{%footer_block}}', 'column_position');
        $this->createIndex('idx-footer_block-status', '{{%footer_block}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%footer_block}}');
    }
}
