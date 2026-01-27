<?php

use yii\db\Migration;

class m260119_184000_fix_announcement_table_schema extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop the old columns
        $this->dropColumn('{{%announcement}}', 'start_date');
        $this->dropColumn('{{%announcement}}', 'end_date');
        $this->dropColumn('{{%announcement}}', 'announcement_type');

        // published_at already exists from previous migration, no need to add it

        // Try to drop old indexes if they exist
        try {
            $this->dropIndex('idx-announcement-type', '{{%announcement}}');
        } catch (\Exception $e) {
            // Index doesn't exist, ignore
        }

        try {
            $this->dropIndex('idx-announcement-dates', '{{%announcement}}');
        } catch (\Exception $e) {
            // Index doesn't exist, ignore
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Reverse the changes
        $this->addColumn('{{%announcement}}', 'announcement_type', $this->string(50)->defaultValue('info'));
        $this->addColumn('{{%announcement}}', 'start_date', $this->date()->notNull());
        $this->addColumn('{{%announcement}}', 'end_date', $this->date());

        $this->createIndex('idx-announcement-type', '{{%announcement}}', 'announcement_type');
        $this->createIndex('idx-announcement-dates', '{{%announcement}}', ['start_date', 'end_date']);
    }
}
