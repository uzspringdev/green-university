<?php

use yii\db\Migration;

class m260119_181239_add_image_to_announcement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%announcement}}', 'image', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%announcement}}', 'image');
    }
}
