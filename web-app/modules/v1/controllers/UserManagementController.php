<?php

namespace WebApp\modules\v1\controllers;

use common\components\WebActiveAuthController;
use common\models\User;
use common\models\UserDetail;
use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;

class UserManagementController extends WebActiveAuthController
{
    public $modelClass = User::class;


    // public function actionIndex()
    // {
    //     return User::find()->all();
    // }

    // public function actionView($id)
    // {
    //     return $this->findModel($id);
    // }


    public function actions()
    {
        $actions = parent::actions();
        // $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        unset($actions['create']);
        // unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $modelDetail = $this->findDetailModel($id);

        if ($model !== null && $modelDetail !== null) {
            $model->status = 9;
            $model->save();
            return ['status' => 'success'];
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionReactivate($id)
    {
        $model = $this->findModel($id);
        $modelDetail = $this->findDetailModel($id);

        if ($model !== null && $modelDetail !== null) {
            $model->status = 10;
            $model->save();
            return ['status' => 'success'];
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionCreate()
    {
        try {
            $model = new User();
            $modelDetail = new UserDetail();
            $param = Yii::$app->request->post();
            $model->load($param, "");
            $model->username = $param['username'];
            $model->email = $param['email'];
            $model->password_hash = Yii::$app->security->generatePasswordHash($param['password']);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->created_at = time();
            $model->updated_at = time();
            $model->status = 10;
            $model->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
            $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            // echo "<pre>";
            // var_dump($param);
            // var_dump($model->username);
            // echo "<pre>";
            // die();
            if ($model->save()) {
                $modelDetail->user_id = $model->id;
                $model->status = 10;
                $model->save();
                if ($modelDetail->load(Yii::$app->request->post(), "") && $modelDetail->save()) {
                    return $model;
                } else {
                    return $this->responseAngularBadRequest400(
                        $this->parsingError($modelDetail->errors)
                    ) ;
                }
            } else {
                return $this->responseAngularBadRequest400(
                     $this->parsingError($model->errors)
                );
            }
        } catch (\Exception $e) {
            return $this->responseAngularBadRequest400($e->getMessage());
            // return $e->getMessage();
            // return $model->errors ? reset($model->errors) : $modelDetail->errors;
        }
    }

    function actionUpdatePassword()
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

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelDetail = $this->findDetailModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($modelDetail->load(Yii::$app->request->post()) && $modelDetail->save()) {
                return $model;
            }
        }

        return [
            'model' => $model,
            'modelDetail' => $modelDetail,
        ];
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findDetailModel($id)
    {
        if (($model = UserDetail::findOne(['user_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
