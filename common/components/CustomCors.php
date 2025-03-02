<?php

/**
 * User: Taufiq Rahman (Rahman.taufiq@gmail.com)
 * Date: 11/08/19
 * Time: 09.35
 */
// use this controller if your API dont need to auth
namespace common\components;

use Yii;
use yii\filters\Cors;
use common\models\AllowedIp;
use common\models\WhitelistIp;

class CustomCors extends Cors
{
    public function beforeAction($action)
    {
        // Get the client's IP address
        $clientIp = Yii::$app->getRequest()->getUserIP();

        // Check if the client IP is in the allowed IPs list
        if (!$this->isIpAllowed($clientIp)) {
            Yii::$app->response->setStatusCode(403);
            Yii::$app->response->data = 'Forbidden';
            Yii::$app->end();
        }

        return parent::beforeAction($action);
    }

    private function isIpAllowed($ip)
    {
        // Check if the IP is in the database table `allowed_ips`
        return WhitelistIp::find()->where(['ip_address' => $ip])->exists();
    }
}
