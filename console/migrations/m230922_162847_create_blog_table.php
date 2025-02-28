<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blog}}`.
 */
class m230922_162847_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blog}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'short_desc' => $this->text(),
            'content' => $this->text(),
            'image_url' => $this->string(),
            'slug' => $this->string(),
            'path' => $this->string(),
            'category' => $this->string(),
            'is_published' => $this->boolean()->defaultValue(0),
            'published_at' => $this->timestamp()->defaultValue(null),
            'status_active' => $this->integer()->defaultValue(1),
            'created_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'deleted_by' => $this->integer(),
        ]);

        // Add foreign key constraints if needed
        // $this->addForeignKey('fk_blog_created_by', '{{%blog}}', 'created_by', '{{%user}}', 'id');
        // $this->addForeignKey('fk_blog_updated_by', '{{%blog}}', 'updated_by', '{{%user}}', 'id');
        // $this->addForeignKey('fk_blog_deleted_by', '{{%blog}}', 'deleted_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blog}}');
    }
}
