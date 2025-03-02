<?php

namespace WebApp\controllers;

use \yii\rest\Controller;
/**
 * Site controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
        return ["status"=> "OK"];
    }
}
