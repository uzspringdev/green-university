<?php

use yii\db\Migration;

/**
 * Class m260127_182700_fix_announcement_schema_force
 */
class m260127_182700_fix_announcement_schema_force extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = '{{%announcement}}';
        $schema = $this->db->getTableSchema($table);

        // Add published_at if missing
        if (!isset($schema->columns['published_at'])) {
            $this->addColumn($table, 'published_at', $this->integer());
        }

        // Drop old columns if present
        if (isset($schema->columns['start_date'])) {
            $this->dropColumn($table, 'start_date');
        }
        if (isset($schema->columns['end_date'])) {
            $this->dropColumn($table, 'end_date');
        }
        if (isset($schema->columns['announcement_type'])) {
            // Drop index if exists before dropping column
            try {
                $this->dropIndex('idx-announcement-type', $table);
            } catch (\Exception $e) {
            }

            $this->dropColumn($table, 'announcement_type');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // This is a repair migration, reverting might not be clean, 
        // but we can try to restore what we might have dropped.
        $table = '{{%announcement}}';
        $schema = $this->db->getTableSchema($table);

        if (!isset($schema->columns['start_date'])) {
            $this->addColumn($table, 'start_date', $this->date());
        }
        if (!isset($schema->columns['end_date'])) {
            $this->addColumn($table, 'end_date', $this->date());
        }
        if (!isset($schema->columns['announcement_type'])) {
            $this->addColumn($table, 'announcement_type', $this->string(50));
        }
        if (isset($schema->columns['published_at'])) {
            $this->dropColumn($table, 'published_at');
        }
    }
}
