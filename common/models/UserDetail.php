<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_detail".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $full_name
 * @property string|null $dob
 * @property string|null $pob
 * @property string|null $gender
 * @property string|null $religion
 * @property string|null $phone_no
 * @property string|null $emergency_no
 * @property string|null $emergency_cp
 * @property string|null $address
 * @property string|null $department
 * @property string|null $job_title
 * @property string|null $job_group
 * @property string|null $education
 * @property string|null $picture
 * @property int $status_active
 * @property int|null $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * @property string|null $nip
 */
class UserDetail extends \common\models\CustomActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['full_name'], 'required'],
            [['dob', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['full_name', 'address', 'picture'], 'string', 'max' => 255],
            [['pob', 'department', 'job_title', 'job_group'], 'string', 'max' => 100],
            [['gender'], 'string', 'max' => 1],
            [['religion', 'phone_no', 'emergency_no', 'nip'], 'string', 'max' => 20],
            [['emergency_cp', 'education'], 'string', 'max' => 30],
            [['phone_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'full_name' => 'Full Name',
            'dob' => 'Dob',
            'pob' => 'Pob',
            'gender' => 'Gender',
            'religion' => 'Religion',
            'phone_no' => 'Phone No',
            'emergency_no' => 'Emergency No',
            'emergency_cp' => 'Emergency Cp',
            'address' => 'Address',
            'department' => 'Department',
            'job_title' => 'Job Title',
            'job_group' => 'Job Group',
            'education' => 'Education',
            'picture' => 'Picture',
            'status_active' => 'Status Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
            'nip' => 'Nip',
        ];
    }

    public $image_url;
    public function fields()
    {
        $fields = parent::fields();
        $this->image_url = Yii::$app->params['host']. $this->picture;
        $fields['image_url'] = "image_url";
        return $fields;
    }
}
