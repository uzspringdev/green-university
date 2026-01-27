<?php

use yii\db\Migration;

/**
 * Class m260119_120000_add_file_column_to_application_table
 */
class m260119_120000_add_file_column_to_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%application}}', 'file', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%application}}', 'file');
    }
}
