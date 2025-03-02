<?php

namespace console\seeds;

use yii\db\Expression;
use yii\db\Migration;

class UserSeeder extends Migration
{
    /**
     * Seed the user table.
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => 'jp6XDJeYLzmdqAygU9bmvtv1Rken85JP',
            'password_hash' => '$2y$13$6V/mkPD4i8obGqD7hfeAmOIcqImtyxrEJM0fpyHC2vdLuoeYmWBza',
            'password_reset_token' => null,
            'email' => 'admin@kansai.com',
            'status' => 9,
            'created_at' => 1695389760,
            'updated_at' => 1695389760,
            'verification_token' => 'DZ4e-WCWAFH2viTnOAErXhWooOPcTAhV_1695389760',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['id' => 1]);
    }
}
