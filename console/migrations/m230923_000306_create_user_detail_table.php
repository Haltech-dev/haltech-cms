<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_detail}}`.
 */
class m230923_000306_create_user_detail_table extends Migration
{
 /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_detail}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'full_name' => $this->string()->notNull(),
            'dob' => $this->date(),
            'pob' => $this->string(100),
            'gender' => $this->string(1),
            'religion' => $this->string(20),
            'phone_no' => $this->string(20),
            'emergency_no' => $this->string(20),
            'emergency_cp' => $this->string(30),
            'address' => $this->string(255),
            'department' => $this->string(100),
            'job_title' => $this->string(100),
            'job_group' => $this->string(100),
            'education' => $this->string(30),
            'picture' => $this->string(255),
            'status_active' => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_by' => $this->integer(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'updated_at' => $this->timestamp()->null()->defaultExpression('NULL ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->timestamp()->null()->defaultExpression('NULL'),
            'nip' => $this->string(20)->null(),
        ]);

        // Add foreign key constraint if needed
        // $this->addForeignKey('fk_user_detail_user_id', '{{%user_detail}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        // Add unique constraint on phone_no column
        $this->createIndex('unique_phone_no', '{{%user_detail}}', 'phone_no', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop the unique constraint on phone_no column
        $this->dropIndex('unique_phone_no', '{{%user_detail}}');

        $this->dropTable('{{%user_detail}}');
    }
}
