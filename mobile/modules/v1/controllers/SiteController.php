<?php

namespace mobile\modules\v1\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return [
            "status"=> 200,
            "message"=> "API Yii2 Aplikasi Mobile Module v1"
        ];
    }
}
