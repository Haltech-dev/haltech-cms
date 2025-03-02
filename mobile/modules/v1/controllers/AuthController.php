<?php

namespace mobile\modules\v1\controllers;

use \yii\rest\Controller;
/**
 * Site controller
 */
class AuthController extends Controller
{
    public function actionIndex()
    {
        return ["status"=> "OK"];
    }

    public function actionLogin()
    {
        return ["status"=> "Login v1"];
    }

    public function actionLoginwithtoken()
    {
        return ["status"=> "Loginwithtoken"];
    }

    public function actionLoginWithTokenNew()
    {
        return ["status"=> "Login-with-token-new"];
    }

    public function actionRegister()
    {
        return ["status"=> "Register"];
    }

}
