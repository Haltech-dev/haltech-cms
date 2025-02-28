<?php

namespace mobile\modules\v1\controllers;


use common\components\UnguardActiveAuthController;
use common\models\Screening;
use common\models\ScreeningSearch;
use common\models\ScreeningUser;
use common\models\ScreeningUserSearch;

class ScreeningUserController extends UnguardActiveAuthController
{
    public $modelClass = ScreeningUser::class;

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new ScreeningUserSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
