<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slider_translation}}`.
 */
class m260118_120013_create_slider_translation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%slider_translation}}', [
            'id' => $this->primaryKey(),
            'slider_id' => $this->integer()->notNull(),
            'language_id' => $this->integer()->notNull(),
            'title' => $this->string(255),
            'subtitle' => $this->string(255),
            'description' => $this->text(),
            'link_text' => $this->string(100),
        ]);

        $this->createIndex('idx-slider_translation-slider_id', '{{%slider_translation}}', 'slider_id');
        $this->createIndex('idx-slider_translation-language_id', '{{%slider_translation}}', 'language_id');
        $this->createIndex('idx-slider_translation-unique', '{{%slider_translation}}', ['slider_id', 'language_id'], true);

        $this->addForeignKey(
            'fk-slider_translation-slider_id',
            '{{%slider_translation}}',
            'slider_id',
            '{{%slider}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-slider_translation-language_id',
            '{{%slider_translation}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-slider_translation-slider_id', '{{%slider_translation}}');
        $this->dropForeignKey('fk-slider_translation-language_id', '{{%slider_translation}}');
        $this->dropTable('{{%slider_translation}}');
    }
}
