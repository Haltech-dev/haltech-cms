<?php

namespace WebApp\modules\v1\controllers;


use common\components\CustomController;
use common\models\User;
use common\helpers\Utils;

use WebApp\models\AuthItemRegister;
use WebApp\modules\v1\models\form\LoginForm;
use Yii;

class AuthController extends CustomController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => '\yii\filters\Cors',
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }



    public function actionLogin()
    {
        date_default_timezone_set("Asia/Bangkok");
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            
            $roleList = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
            $roleName = [];
            // foreach ($roleList as $role) {
            //     $auth = AuthItemRegister::findOne(['name' => $role->name]);
            //     // $roleName[] = $role;
            //     $roleName[] = $auth;
            // }
            

            $data = [
                'user_id' => $model->user->id,
                'username' => $model->user->username,
                'initial' => Utils::generateInitial(@$model->user->userDetail->full_name),
                'nip' => @$model->user->userDetail->nip,
                'fullname' => @$model->user->userDetail->full_name,
                'gender' => @$model->user->userDetail->gender,
                'phone' => @$model->user->userDetail->phone_no,
                'dob' => @$model->user->userDetail->dob,
                'address' => @$model->user->userDetail->address,
                'department' => @$model->user->userDetail->department,
                'picture' => @$model->user->userDetail->picture,
                'auth_key' => $model->user->auth_key,
                'auth' => $roleName,
                // 'is_login' => $model->user->is_login,
                // 'user_detail' => @$model->user->userDetail,
                
            ];

            return $this->responseSuccessItems($data, 'Login success');
        } else {
            return $this->responseNotFound("failed", $this->parsingError($model->errors));
        }
    }

    public function actionUserByToken($token)
    {
        $userModel = User::find()->where(['auth_key' => $token])->one();
        if (!$userModel) {
            return $this->responseNotFoundMobile(404, 'Invalid user name or password');
        }
        // Yii::$app->user = $userModel;

        $roleList = Yii::$app->authManager->getRolesByUser($userModel->id);
        // $colorCode = AppConfig::getValueByAppName('app-web-color-code');
        // $config = AppConfig::getValueByAppName('app-web');
        $roleName = [];
        foreach ($roleList as $role) {
            $roleName[] = $role;
        }

        $jobTitle = @$userModel->userDetail->job_title;
        
        $data = [
            'user_id' => $userModel->id,
            'username' => $userModel->username,
            'nip' => @$userModel->userDetail->nip,
            'fullname' => @$userModel->userDetail->full_name,
            'gender' => @$userModel->userDetail->gender,
            'phone' => @$userModel->userDetail->phone_no,
            'dob' => @$userModel->userDetail->dob,
            'address' => @$userModel->userDetail->address,
            'department' => @$userModel->userDetail->department,
            'job_title' => $jobTitle,
            'picture' => @$userModel->userDetail->picture,
            'auth_key' => $userModel->auth_key,
            'auth' => $roleName,
            // 'config' => $config,
            // 'color_code' => $colorCode,
            'is_login' => $userModel->is_login,
            
        ];

        return $this->responseSuccessItems($data, 'Data User Loaded');
    }

    public function actionCheckAuth()
    {
        $model = \Yii::$app->getRequest()->getBodyParams();
        $authKey = @$model['auth_key'];
        if (!$authKey) {
            return $this->responseAngularError200(404, false);
        }
        $user = User::findIdentityByAccessToken($authKey);
        if ($user) {
            return $this->responseAngularSuccess200(true);
        } else {
            return $this->responseAngularError200(404, false);
        }
    }

    public function actionLogout()
    {
        $model = \Yii::$app->getRequest()->getBodyParams();
        $authKey = $model['auth_key'];

        $user = User::findIdentityByAccessToken($authKey);
        if ($user) {
            return $this->responseSuccessItems("", 'Logout success');
        } else {
            return $this->responseNotFoundMobile('Auth key not found', 'Logout error');
        }
    }

    // public function actionRegister()
    // {
    //     $model = new RegisterForm();
    //     if ($model->load(Yii::$app->request->post(), '') && $model->authtoregister()) {
    //         return ["status" => 'success'];
    //     }
    //     return ['error' => $model->errors];
    // }
}
