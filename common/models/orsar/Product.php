<?php

namespace common\models\orsar;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $name
 * @property int $price
 * @property string $currency
 * @property int $weight
 * @property string $uom
 *
 * @property CommerceLink[] $commerceLinks
 * @property ProductDetail[] $productDetails
 * @property Upload[] $uploads
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
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
            [['id', 'name', 'price', 'weight', 'uom'], 'required'],
            [['price', 'weight'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['name', 'currency', 'uom'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'currency' => 'Currency',
            'weight' => 'Weight',
            'uom' => 'Uom',
        ];
    }

    /**
     * Gets query for [[CommerceLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCommerceLinks()
    {
        return $this->hasMany(CommerceLink::class, ['productId' => 'id']);
    }

    /**
     * Gets query for [[ProductDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductDetails()
    {
        return $this->hasMany(ProductDetail::class, ['productId' => 'id']);
    }

    /**
     * Gets query for [[Uploads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUploads()
    {
        return $this->hasMany(Upload::class, ['productId' => 'id']);
    }


    function extraFields()
    {
        return ['uploads','productDetails'];
    }

}
