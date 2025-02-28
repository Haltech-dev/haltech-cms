<?php

namespace common\components;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use mdm\admin\components\AccessControl;

class WebAuthController extends \yii\rest\Controller
{
    private $_verbs = ['GET', 'POST', 'PUT', 'HEAD', 'OPTIONS'];
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // TODO rate limiter belum active ya
        $auth = $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        unset($behaviors['authenticator']);

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'OPTIONS'],
                'Access-Control-Expose-Headers' => ['X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                // 'Access-Control-Allow-Credentials' => true,
            ],
        ];

        $behaviors['authenticator'] = $auth;
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

    public function beforeAction($action)
    {
        date_default_timezone_set('Asia/Jakarta');
        $options = $this->_verbs;
        parent::beforeAction($action);
        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $options));
            Yii::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Methods', implode(', ', $options));
            Yii::$app->end();
        }
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
    public function responseAngularNotFound($errors)
    {
        Yii::$app->response->statusCode = 200;
        return ['message' => $errors];
    }
    /**
     * response Not Found
     */
    public function responseAngularNotFound404($errors)
    {
        Yii::$app->response->statusCode = 404;
        return ['message' => $errors];
    }
    public function responseAngularNotFound200($errors)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => false,
            'data' => $errors
        ];
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
    //TODO tambahkan bila ada respon yang belum ada

    public function responseAngularBadRequest($errors)
    {
        Yii::$app->response->statusCode = 400;
        return ['status' => false, 'message' => $errors];
    }

    public function responseAngularSuccess200($data)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => true,
            'data' => $data
        ];
    }
    public function responseAngularError200($code, $data)
    {
        Yii::$app->response->statusCode = 200;
        return [
            'status' => false,
            'error' => $code,
            'message' => $data
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
}
