<?php

use yii\db\Migration;

/**
 * Class m260118_220000_add_timestamp_to_news_category
 */
class m260118_220000_add_timestamp_to_news_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news_category}}', 'created_at', $this->integer());
        $this->addColumn('{{%news_category}}', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news_category}}', 'updated_at');
        $this->dropColumn('{{%news_category}}', 'created_at');
    }
}
