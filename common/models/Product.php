<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produk".
 *
 * @property int $id
 * @property string|null $category
 * @property string $title
 * @property string|null $short_desc
 * @property string|null $content
 * @property string|null $image_url
 * @property string|null $slug
 * @property string|null $path
 * @property int|null $is_published
 * @property string|null $published_at
 * @property int|null $status_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class Product extends \common\models\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['title'], 'required'],
            [['title_id', 'title','title_en','short_desc', 'content', 'content_id', 'content_en'], 'string'],
            [['is_published', 'status_active', 'created_by', 'updated_by', 'deleted_by', 'position'], 'integer'],
            [['published_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['category', 'title', 'image_url', 'slug', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'title' => 'Title',
            'short_desc' => 'Short Desc',
            'content' => 'Content',
            'image_url' => 'Image Url',
            'slug' => 'Slug',
            'path' => 'Path',
            'is_published' => 'Is Published',
            'published_at' => 'Published At',
            'status_active' => 'Status Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
