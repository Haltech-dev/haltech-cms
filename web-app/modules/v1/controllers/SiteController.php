<?php

namespace WebApp\modules\v1\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return [
            "status"=> 200,
            "message"=> "Module crud"
        ];
    }
}
