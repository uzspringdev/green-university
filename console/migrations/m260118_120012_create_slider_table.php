<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slider}}`.
 */
class m260118_120012_create_slider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%slider}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string(255),
            'link_url' => $this->string(255),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-slider-status', '{{%slider}}', 'status');
        $this->createIndex('idx-slider-sort_order', '{{%slider}}', 'sort_order');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%slider}}');
    }
}
