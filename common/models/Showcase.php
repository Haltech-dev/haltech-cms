<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "showcase".
 *
 * @property int $id
 * @property string|null $title_en
 * @property string $title_id
 * @property string|null $short_desc
 * @property string|null $image_url
 * @property string|null $path
 * @property int|null $position
 * @property int|null $status_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class Showcase extends \common\models\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'showcase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_id'], 'required'],
            [['short_desc'], 'string'],
            [['position', 'status_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title_en', 'title_id', 'image_url', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_en' => 'Title En',
            'title_id' => 'Title ID',
            'short_desc' => 'Short Desc',
            'image_url' => 'Image Url',
            'path' => 'Path',
            'position' => 'Position',
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
