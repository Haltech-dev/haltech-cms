<?php

namespace WebApp\modules\v1\controllers;

use common\components\WebActiveAuthController;
use common\models\JobApplicant;
use common\models\JobApplicantSearch;
use common\models\JobOpenings;
use common\models\JobOpeningSearch;
use Yii;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class JobController extends WebActiveAuthController
{
    public $modelClass = JobOpenings::class;
    public $pathProduct = 'uploads/jobs/';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new JobOpeningSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    function actionCreate()
    {
        $model = new JobOpenings();
        if ($model->load(Yii::$app->request->post(), '')) {
            $image = UploadedFile::getInstanceByName('cv');
            $fileExt = ['jpg', 'jpeg', 'png'];
            if (!$image) {
                return $this->responseAngularNotFound('upload error, unknow image format');
            }

            if (!in_array($image->extension, $fileExt)) {
                return $this->responseAngularNotFound('Upload gagal, dokumen harus berupa file pdf.');
            }
            $name = $image->baseName;

            $filename = $name . "-" . time() . '.' . $image->extension;
            $path = $this->pathProduct  . $filename;
            $model->path = $path;
            $model->pdf_url = Yii::$app->params['host'] . '/' . $path;
            if ($model->validate() && $image->saveAs(Yii::getAlias('@baseweb') .'/'. $path)) {

                $model->save(false);
                return $this->responseAngularSuccessItems([
                    "status" => "success",
                    'data' => $model
                ]);
            }
            return $this->responseAngularNotFound($this->parsingError($model->errors));
        }
    }

    function actionUpdate($id)
    {
        $model = JobOpenings::findOne($id);
        if (!$model) {
            return $this->responseAngularNotFound('data not found');
        }

        if ($model->load(Yii::$app->request->post(), '')) {
            $image = UploadedFile::getInstanceByName('cv');
            $fileExt = ['jpg', 'jpeg', 'png'];
            if ($image) {

                if (!in_array($image->extension, $fileExt)) {
                    return $this->responseAngularNotFound('Upload gagal, dokumen harus berupa file pdf.');
                }
                $oldPath = $model->path;
                $oldFile =  $oldPath;

                $name = $image->baseName;

                $filename = $name . "-" . time() . '.' . $image->extension;
                $path = $this->pathProduct  . $filename;


                $model->path = $path;
                $model->image_url = Yii::$app->params['host'] . '/'  . $path;
                if ($image->saveAs(Yii::getAlias('@baseweb').'/' .$path)) {
                    try {
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                } else {
                    return $this->responseAngularNotFound($this->parsingError($model->errors));
                }
            }

            if ($model->validate()) {

                $model->save(false);
                return $this->responseAngularSuccessItems([
                    "status" => "success",
                    'data' => $model
                ]);
            }
            return $this->responseAngularNotFound($this->parsingError($model->errors));
        }
    }
}
