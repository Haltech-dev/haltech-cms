<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_openings}}`.
 */
class m250226_143338_create_job_openings_table extends Migration
{public function safeUp()
    {
        $this->createTable('{{%job_openings}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'position' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'company_name' => $this->string()->notNull(),
            'location' => $this->string()->notNull(),
            "work_type" => "ENUM('WFH', 'WFO', 'Hybrid') NOT NULL",
            'experience' => $this->string(),
            'education' => $this->string(),
            'age' => $this->string(50),
            'skills' => $this->text(),
            'stages' => $this->text(), // Recruitment stages
            'document' => $this->text(), // Required documents
            'salary_range' => $this->string(100),
            "job_type" => "ENUM('Full-time', 'Part-time', 'Contract', 'Internship') NOT NULL",
            'posted_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'expires_at' => $this->dateTime()->defaultValue(null),
            'status_active' => $this->integer()->defaultValue(1),
            'created_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'deleted_by' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%job_openings}}');
    }
}
