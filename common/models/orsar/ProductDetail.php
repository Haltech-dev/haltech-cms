<?php

namespace common\models\orsar;

use Yii;

/**
 * This is the model class for table "product_detail".
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string|null $productId
 *
 * @property Product $product
 */
class ProductDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_detail';
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
            [['id', 'title', 'description'], 'required'],
            [['id', 'productId'], 'string', 'max' => 36],
            [['title', 'description'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['productId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'productId' => 'Product ID',
        ];
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
        return ['product'];
    }
}
