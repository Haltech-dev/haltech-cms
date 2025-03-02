<?php

namespace WebApp\modules\v1\controllers;

use common\components\WebActiveAuthController;
use common\models\Blog;
use common\models\BlogSearch;
use Yii;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class BlogController extends WebActiveAuthController
{
    public $modelClass = Blog::class;


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
        $searchModel = new BlogSearch(); // lihat model search
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    function actionCreate()
    {
        $model = new Blog();
        if ($model->load(Yii::$app->request->post(), '')) {
            $image = UploadedFile::getInstanceByName('image');
            $fileExt = ['jpg', 'jpeg', 'png'];
            if (!$image) {
                return $this->responseAngularNotFound('upload error, unknow image format');
            }

            if (!in_array($image->extension, $fileExt)) {
                return $this->responseAngularNotFound('Upload gagal, dokumen harus berupa file Excel.');
            }
            $name = $image->baseName;

            $filename = $name . "-" . time() . '.' . $image->extension;
            $path = 'uploads/blog/'  . $filename;
            $model->path = $path;
            if($model->is_published == 1){
                $model->published_at = date('Y-m-d H:i:s');
            }
            $model->image_url = Yii::$app->params['host'] . "/". $path;
            if ($model->validate() && $image->saveAs(Yii::getAlias('@baseweb').'/' .$path, 1)) {

                $model->save(false);
                return $this->responseAngularSuccessItems([
                    "status" => "success",
                    'data' => $model
                ]);
            }
            return $this->responseAngularNotFound($this->parsingError($model->errors));
        }
    }

    function actionPublish($id)
    {
        $model = Blog::findOne($id);
        if (!$model) {
            return $this->responseAngularNotFound('data not found');
        }

        $model->status = 'published';
        if ($model->save(false)) {
            return $this->responseAngularSuccessItems([
                "status" => "success",
                'data' => $model
            ]);
        }
        return $this->responseAngularNotFound($this->parsingError($model->errors));
    }

    function actionUpdate($id)
    {
        $model = Blog::findOne($id);
        if (!$model) {
            return $this->responseAngularNotFound('data not found');
        }

        if ($model->load(Yii::$app->request->post(), '')) {
            $image = UploadedFile::getInstanceByName('image');
            $fileExt = ['jpg', 'jpeg', 'png'];
            if ($image) {

                if (!in_array($image->extension, $fileExt)) {
                    return $this->responseAngularNotFound('Upload gagal, dokumen harus berupa file Excel.');
                }
                $oldPath = $model->path;
                $oldFile =  $oldPath;

                $name = $image->baseName;

                $filename = $name . "-" . time() . '.' . $image->extension;
                $path = 'uploads/blog/'  . $filename;

                $model->path = $path;
                if($model->is_published == 1){
                    $model->published_at = date('Y-m-d H:i:s');
                }
                $model->image_url = Yii::$app->params['host'] . "/" . $path;
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
