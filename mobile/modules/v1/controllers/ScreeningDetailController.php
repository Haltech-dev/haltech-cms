<?php

namespace mobile\modules\v1\controllers;


use common\components\UnguardActiveAuthController;
use common\models\Screening;
use common\models\ScreeningDetail;
use common\models\ScreeningDetailSearch;
use common\models\ScreeningSearch;
use common\models\ScreeningUser;
use common\models\ScreeningUserDetail;
use common\models\ScreeningUserDetailSearch;

class ScreeningUserDetailController extends UnguardActiveAuthController
{
    public $modelClass = ScreeningUserDetail::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ScreeningUserDetailSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
