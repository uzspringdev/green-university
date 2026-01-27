<?php

use yii\db\Migration;

class m260118_220132_add_firstname_lastname_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'first_name', $this->string(100)->null());
        $this->addColumn('{{%user}}', 'last_name', $this->string(100)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'last_name');
        $this->dropColumn('{{%user}}', 'first_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260118_220132_add_firstname_lastname_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
