<?php

use yii\db\Migration;

class m260118_210347_add_role_and_permissions_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role', $this->smallInteger()->notNull()->defaultValue(10));
        $this->addColumn('{{%user}}', 'permissions', $this->text());

        // Update existing first user to Super Admin (ROLE_SUPER_ADMIN = 20)
        // and give all permissions
        $allPermissions = json_encode(['news', 'applications', 'pages', 'menus', 'sliders', 'logs', 'users']);
        $this->update('{{%user}}', [
            'role' => 20,
            'permissions' => $allPermissions
        ], ['id' => 1]);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'permissions');
        $this->dropColumn('{{%user}}', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260118_210347_add_role_and_permissions_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
