<?php

use yii\db\Migration;

/**
 * Class m260127_172300_fix_menu_column_name
 */
class m260127_172300_fix_menu_column_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%menu}}', 'location', 'code');
        $this->dropIndex('idx-menu-location', '{{%menu}}');
        $this->createIndex('idx-menu-code', '{{%menu}}', 'code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%menu}}', 'code', 'location');
        $this->dropIndex('idx-menu-code', '{{%menu}}');
        $this->createIndex('idx-menu-location', '{{%menu}}', 'location');
    }
}
