<?php

namespace WebApp\modules\v1\modules\lp\controllers;

use common\components\UnguardActiveAuthController;
use common\models\Blog;
use common\models\BlogSearch;
use common\models\Product;
use common\models\ProductSearch;
use common\models\Showcase;
use common\models\ShowcaseSearch;

/**
 * Site controller
 */
class ShowcaseController extends UnguardActiveAuthController
{
    public $modelClass = Showcase::class;
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
        $searchModel = new ShowcaseSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

}
