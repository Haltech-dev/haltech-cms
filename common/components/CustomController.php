<?php

/**
 * User: Taufiq Rahman (Rahman.taufiq@gmail.com)
 * Date: 11/08/19
 * Time: 09.35
 */
// use this controller if your API dont need to auth
namespace common\components;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

class CustomController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Allow-Origin' => ['*'],
            ],
        ];
        // unset($behaviors['authenticator']);
        $behaviors['authenticator'] = $auth;
        // $behaviors['ApiLogging'] =
        //     [
        //         'class' => ApiLogging::class,
        //         'LOG_ON_ERROR' => true // get all error response, false value to disable error message in your log DB
        //     ];
            
        return $behaviors;
    }

    /**
     * response Not Found
     */
    public function responseNotFound($errors, $message = false)
    {
        Yii::$app->response->statusCode = 404;
        return [
            'name' => 'Resource Not Found',
            'message' => $message ? $message : 'Your request not exist, please contact Admin!',
            'code' => 101,
            'status' => 404,
            'type' => $errors
        ];
    }

    /**
     * response Item response
     */
    public function responseSuccessItems($data, $message = false)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'code' => 200,
            'message' => $message ? $message : 'Data retrieval successfully',
            'data' => $data
        ];
    }

    /**
     * response Success response
     */
    public function responseSuccess($message = false)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'code' => 200,
            'message' => $message ? $message : 'Success',
        ];
    }
    /*
    * parsingErorr use for make object from $model->errors convert to line of string
    * so it can be pass to restful's error message.
    */
    public function parsingError($objs)
    {
        $data = '';
        foreach ($objs as $obj) {
            $data = $data . $obj[0];
        }
        return $data;
    }


    /**
     * response Not Found 200
     */
    public function responseNotFoundMobile($errors, $message = false)
    {
        Yii::$app->response->statusCode = 404;
        return [
            'name' => $errors ? $errors : "Data not found",
            'message' => $message ? $message : 'Your request not exist, please contact Admin!',
            // 'code' => 404,
            'status' => Yii::$app->response->statusCode,
            'type' => $errors,
            // 'statusCode' => $code,
        ];
    }

    public function responseBadRequestMobile($code, $errors, $message = false)
    {
        Yii::$app->response->statusCode = 400;
        return [
            'name' => "Data not found",
            'message' => $message ? $message : $errors,
            'code' => 400,
            'status' => Yii::$app->response->statusCode,
            'type' => $errors,
            // 'statusCode' => $code,
        ];
    }

    public function responseSuccessMobile($msg = null, $data = null)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => Yii::$app->response->statusCode,
            "success" => true,
            'message' => $msg,
            "data" => $data,
        ];
    }

    public function response200MobileEmpty($msg, $data = null)
    {
        Yii::$app->response->statusCode = 200;
        return [

            'status' => Yii::$app->response->statusCode,
            "success" => true,
            'message' => $msg,
            "data" => $data,

        ];
    }


    public function responseSuccessItemsMobile($data, $message = false)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => 200,
            "success" => true,
            'message' => $message ? $message : 'Data retrieval successfully',
            'data' => $data
        ];
    }
}
