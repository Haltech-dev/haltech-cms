<?php

namespace WebApp\modules\v1\modules\lp\controllers;

use common\components\UnguardActiveAuthController;
use common\models\Blog;
use common\models\BlogSearch;

/**
 * Site controller
 */
class ProductController extends UnguardActiveAuthController
{
    public $modelClass = Blog::class;


    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new BlogSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

}
