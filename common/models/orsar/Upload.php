<?php

namespace common\models\orsar;

use Yii;

/**
 * This is the model class for table "upload".
 *
 * @property string $id
 * @property string $url
 * @property string $thumbnail
 * @property string|null $productId
 *
 * @property Banner $banner
 * @property Product $product
 */
class Upload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('orsar');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'url'], 'required'],
            [['id', 'productId'], 'string', 'max' => 36],
            [['url', 'thumbnail'], 'string', 'max' => 255],
            [['id'], 'unique'],
            // [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['productId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'thumbnail' => 'Thumbnail',
            'productId' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Banner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banner::class, ['imageId' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'productId']);
    }


    function extraFields()
    {
        return ['banner','product'];
    }
}
