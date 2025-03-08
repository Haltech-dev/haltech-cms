<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string|null $short_desc
 * @property string|null $content
 * @property string|null $image_url
 * @property string|null $slug
 * @property string|null $path
 * @property string|null $category
 * @property int|null $is_published
 * @property string|null $published_at
 * @property int|null $status_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property string|null $author
 * @property string|null $reviewer
 */
class Blog extends \common\models\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['short_desc', 'content'], 'string'],
            [['content'], 'string', 'max' => 10000000], // 1 million characters
            [['is_published', 'status_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['published_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'image_url', 'slug', 'path', 'category', 'author', 'reviewer'], 'string', 'max' => 255],
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
            'short_desc' => 'Short Desc',
            'content' => 'Content',
            'image_url' => 'Image Url',
            'slug' => 'Slug',
            'path' => 'Path',
            'category' => 'Category',
            'is_published' => 'Is Published',
            'published_at' => 'Published At',
            'status_active' => 'Status Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'author' => 'Author',
            'reviewer' => 'Reviewer',
        ];
    }
}
