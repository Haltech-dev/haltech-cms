<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "job_openings".
 *
 * @property int $id
 * @property string $title
 * @property string $position
 * @property string $description
 * @property string $company_name
 * @property string $location
 * @property string $work_type
 * @property string|null $experience
 * @property string|null $education
 * @property string|null $age
 * @property string|null $skills
 * @property string|null $stages
 * @property string|null $document
 * @property string|null $salary_range
 * @property string $job_type
 * @property string|null $posted_at
 * @property string|null $expires_at
 * @property int|null $status_active
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property string|null $email
 * @property string|null $gform_link
 * @property string|null $image_url
 */
class JobOpenings extends \common\models\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_openings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'position', 'description', 'company_name', 'location', 'work_type', 'job_type'], 'required'],
            [['description', 'work_type', 'skills', 'stages', 'document', 'job_type'], 'string'],
            [['posted_at', 'expires_at', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['status_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['title', 'position', 'company_name', 'location', 'experience', 'education', 'email', 'gform_link', 'image_url'], 'string', 'max' => 255],
            [['age'], 'string', 'max' => 50],
            [['salary_range'], 'string', 'max' => 100],
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
            'position' => 'Position',
            'description' => 'Description',
            'company_name' => 'Company Name',
            'location' => 'Location',
            'work_type' => 'Work Type',
            'experience' => 'Experience',
            'education' => 'Education',
            'age' => 'Age',
            'skills' => 'Skills',
            'stages' => 'Stages',
            'document' => 'Document',
            'salary_range' => 'Salary Range',
            'job_type' => 'Job Type',
            'posted_at' => 'Posted At',
            'expires_at' => 'Expires At',
            'status_active' => 'Status Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'email' => 'Email',
            'gform_link' => 'Gform Link',
            'image_url' => 'Image Url',
        ];
    }
}
