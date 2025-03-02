<?php

namespace WebApp\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return [
            "status"=> 200,
            "message"=> "API Yii2 Aplikasi WebApp"
        ];
    }

    public function actionError()
    {
        return [
            "status"=> 400,
            "message"=> "Route not found"
        ];
    }
}
