<?php

use yii\db\Migration;

/**
 * Class m230926_155650_whitelist_ip
 */
class m230926_155650_whitelist_ip extends Migration
{/**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('whitelist_ip', [
            'id' => $this->primaryKey(),
            'ip_address' => $this->string(45)->notNull(),
            'status_active' => $this->integer()->defaultValue(1),
            'created_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer(),
            'deleted_at' => $this->timestamp()->defaultValue(null),
            'deleted_by' => $this->integer(),
        ]);

        // You can also create indexes or foreign keys if needed.
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('whitelist_ip');
    }
}
