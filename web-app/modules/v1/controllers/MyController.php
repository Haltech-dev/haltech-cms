<?php

namespace WebApp\modules\v1\controllers;

use common\components\CustomController;
use common\models\User;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

class MyController extends CustomController
{
    function actionIndex()
    {
        return [
            'status' => 'success',
            'message' => 'Welcome to MyController',
        ];
    }
    public function actionUpdatePassword()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);

        if (!$user) {
            throw new BadRequestHttpException("User not found.");
        }

        $params = Yii::$app->request->post();

        if (isset($params['old_password']) && isset($params['new_password'])) {
            if (!$user->validatePassword($params['old_password'])) {
                throw new BadRequestHttpException("Old password is incorrect.");
            }
            $user->setPassword($params['new_password']);
        }

        if ($user->save()) {
            return [
                'status' => 'success',
            ];
        } else {
            $this->responseBadRequestMobile(400, $user->errors, 'Update failed.');
        }
    }

    public function actionUpdateProfile()
    {
        $user_id = Yii::$app->user->id;
        $user = User::findOne($user_id);
        // var_dump($user->userDetail);
        // die();

        if (!$user) {
            throw new BadRequestHttpException("User not found.");
        }

        $params = Yii::$app->request->post();

        // Assuming 'UserDetail' is the related model for user details
        $userDetail = $user->userDetail;

        if (!$userDetail) {
            throw new BadRequestHttpException("User detail not found.");
        }

        $image = UploadedFile::getInstanceByName('image');
        $fileExt = ['jpg', 'jpeg', 'png'];
        if ($image) {

            if (!in_array($image->extension, $fileExt)) {
                return $this->responseNotFound("WRONG_FORMAT",'Upload gagal, dokumen harus berupa file gambar.');
            }
            $oldPath = $userDetail->picture;
            $oldFile =  $oldPath;

            $name = $image->baseName;

            $filename = $name . "-" . time() . '.' . $image->extension;
            $path = 'uploads/blog/'  . $filename;

            $userDetail->picture = $path;
            // $userDetail->image_url = Yii::$app->params['host'] . "/" . $path;
            if ($image->saveAs(Yii::getAlias('@baseweb') . '/' . $path)) {
                try {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            } else {
                return $this->responseAngularNotFound($this->parsingError($userDetail->errors));
            }
        }

        $userDetail->attributes = $params;

        if ($userDetail->save()) {
            return [
                'status' => 'success',
                'data' => $userDetail,
            ];
        } else {
            $this->responseBadRequestMobile(400, $userDetail->errors, 'Update failed.');
        }
    }
}
