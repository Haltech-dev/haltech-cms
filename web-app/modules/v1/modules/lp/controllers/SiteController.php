<?php

namespace WebApp\modules\v1\modules\lp\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return [
            "status"=> 200,
            "message"=> "Module landing page"
        ];
    }
}
