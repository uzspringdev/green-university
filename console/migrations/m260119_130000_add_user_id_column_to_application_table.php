<?php

use yii\db\Migration;

/**
 * Class m260119_130000_add_user_id_column_to_application_table
 */
class m260119_130000_add_user_id_column_to_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%application}}', 'user_id', $this->integer()->null());

        // Creates index for column `user_id`
        $this->createIndex(
            '{{%idx-application-user_id}}',
            '{{%application}}',
            'user_id'
        );

        // Add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-application-user_id}}',
            '{{%application}}',
            'user_id',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-application-user_id}}',
            '{{%application}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-application-user_id}}',
            '{{%application}}'
        );

        $this->dropColumn('{{%application}}', 'user_id');
    }
}
