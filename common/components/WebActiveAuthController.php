<?php

/**
 * User: Taufiq Rahman (Rahman.taufiq@gmail.com)
 * Date: 11/08/19
 * Time: 09.35
 */
// this controller need  auth to use resource
namespace common\components;

use Yii;
use yii\filters\auth\HttpBearerAuth;
// use yii\web\Response;
use mdm\admin\components\AccessControl;
use yii\rest\ActiveController;

class WebActiveAuthController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // TODO rate limiter belum active ya
        // $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        // add CORS filter
        
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => '\yii\filters\Cors',
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Methods' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        // TODO saat ini RBAC belum di jalankan
        // $behaviors['access'] = [
        //     'class' => AccessControl::class,
        // ];
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        // $behaviors['ApiLogging'] =
        //     [
        //         'class' => ApiLogging::class,
        //         'LOG_ON_ERROR' => true // get all error response, false value to disable error message in your log DB
        //     ];

        return $behaviors;
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'common\components\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'common\components\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        date_default_timezone_set('Asia/Jakarta');
        parent::beforeAction($action);
        return true;
    }

    /*
    * response for Angular web
    */
    /**
     * response Item response
     */
    public function responseAngularSuccessItems($data)
    {
        Yii::$app->response->statusCode = 200;

        return $data;
    }
    /**
     * response Not Found
     */
    public function responseAngularNotFound($errors, $message = false)
    {
        Yii::$app->response->statusCode = 200;
        return ['message' => $errors];
    }
    
    /**
     * response Bad Request
     */
    public function responseAngularBadRequest($errors)
    {
        Yii::$app->response->statusCode = 402;
        return ['status' => false, 'message' => $errors];
    }

    public function responseAngularBadRequest400($errors)
    {
        Yii::$app->response->statusCode = 400;
        return ['status' => false, 'message' => $errors];
    }
    // public function responseAngularBadRequest200($errors)
    // {
    //     Yii::$app->response->statusCode = 200;
    //     return ['status' => false, 'message' => $errors];
    // }
    /**
     * response Not Found
     */
    public function responseAngularNotFound404($errors = 'Not Found')
    {
        Yii::$app->response->statusCode = 404;
        return ['message' => $errors];
    }

    /**
     * response Updated response
     */
    public function responseAngularUpdated($message = false)
    {
        Yii::$app->response->statusCode = 202;

        return [
            'message' => $message ? $message : 'Updated successfully'
        ];
    }
    /**
     * response Deleted response
     */
    public function responseAngularDeleted($message = false)
    {
        Yii::$app->response->statusCode = 204;
        return [
            'message' => $message ? $message : 'Deleted successfully'
        ];
    }
    /**
     * response Success response
     */
    public function responseAngularSuccess($message = false)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'statusCode' => 200,
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

    public function responseAngularSuccess200($data)
    {
        Yii::$app->response->statusCode = 200;

        return [
            'status' => true,
            'data' => $data
        ];
    }
    /**
     * response Not Found
     */
    public function responseAngularError($code, $errors)
    {
        Yii::$app->response->statusCode = 400;
        return [
            'status' => false,
            'error' => $code,
            'message' => $errors
        ];
    }

    public function responseAngularError200($code, $errors)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => false,
            'error' => $code,
            'message' => $errors
        ];
    }
}
