<?php

namespace common\models\orsar;

use Yii;

/**
 * This is the model class for table "commerce_link".
 *
 * @property string $id
 * @property string $commerce
 * @property string $link
 * @property string|null $productId
 *
 * @property Product $product
 */
class CommerceLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'commerce_link';
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
            [['id', 'commerce', 'link'], 'required'],
            [['id', 'productId'], 'string', 'max' => 36],
            [['commerce', 'link'], 'string', 'max' => 255],
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
            'commerce' => 'Commerce',
            'link' => 'Link',
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
