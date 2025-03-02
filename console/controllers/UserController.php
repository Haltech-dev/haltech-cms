<?php

namespace console\controllers;

use yii\console\Controller;
use yii\db\Expression;
use yii\db\Transaction;
use common\models\User;

class UserController extends Controller
{
    /**
     * Seed the user table.
     *
     * @return bool
     */
    public static function actionRun()
    {
        // Create a transaction to ensure data consistency.
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            // Insert user data.
            \Yii::$app->db->createCommand()->insert(User::tableName(), [
                'id' => 1,
                'username' => 'admin',
                'auth_key' => 'jp6XDJeYLzmdqAygU9bmvtv1Rken85JP',
                'password_hash' => '$2y$13$6V/mkPD4i8obGqD7hfeAmOIcqImtyxrEJM0fpyHC2vdLuoeYmWBza',
                'password_reset_token' => null,
                'email' => 'admin@kansai.com',
                'status' => 9,
                'created_at' => new Expression('1695389760'),
                'updated_at' => new Expression('1695389760'),
                'verification_token' => 'DZ4e-WCWAFH2viTnOAErXhWooOPcTAhV_1695389760',
            ])->execute();

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction.
            $transaction->rollBack();
            echo "Seeder error: " . $e->getMessage() . "\n";
            return false;
        }
    }
}
