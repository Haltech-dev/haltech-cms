<?php

namespace common\models\orsar;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property string $id
 * @property string $startDate
 * @property string $endDate
 * @property string|null $imageId
 *
 * @property Upload $image
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
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
            [['id', 'startDate', 'endDate'], 'required'],
            [['startDate', 'endDate'], 'safe'],
            [['id', 'imageId'], 'string', 'max' => 36],
            // [['imageId'], 'unique'],
            [['id'], 'unique'],
            // [['imageId'], 'exist', 'skipOnError' => true, 'targetClass' => Upload::class, 'targetAttribute' => ['imageId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'imageId' => 'Image ID',
        ];
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Upload::class, ['id' => 'imageId']);
    }

    function extraFields()
    {
        return ['image'];
    }
}
