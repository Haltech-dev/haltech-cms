<?php

namespace WebApp\modules\v1\modules\lp\controllers;

use common\components\UnguardActiveAuthController;
use common\models\Blog;
use common\models\BlogSearch;
use common\models\JobOpenings;
use common\models\JobOpeningSearch;

/**
 * Site controller
 */
class JobController extends UnguardActiveAuthController
{
    public $modelClass = JobOpenings::class;


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
        $searchModel = new JobOpeningSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

}
