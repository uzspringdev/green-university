<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string|null $program
 * @property string|null $message
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Application extends ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_APPROVED = 2;
    const STATUS_REJECTED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    /**
     * @var \yii\web\UploadedFile
     */
    public $uploadFile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'phone'], 'required'],
            [['message'], 'string'],
            [['status'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['program'], 'string', 'max' => 255],
            [['file'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['status'], 'in', 'range' => [self::STATUS_NEW, self::STATUS_PROCESSING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
            [['uploadFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, doc, docx, jpg, png, zip', 'maxSize' => 50 * 1024 * 1024, 'checkExtensionByMimeType' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'program' => 'Program',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get full name
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        $statuses = [
            self::STATUS_NEW => 'New',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
        ];
        return $statuses[$this->status] ?? 'Unknown';
    }

    /**
     * Get status options for dropdown
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    /**
     * Uploads the file.
     * @return bool whether the upload was successful
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->uploadFile) {
                $path = 'uploads/applications/' . $this->uploadFile->baseName . '.' . $this->uploadFile->extension;

                // Ensure directory exists
                if (!is_dir('uploads/applications')) {
                    mkdir('uploads/applications', 0777, true);
                }

                // If file with same name exists, append timestamp
                if (file_exists($path)) {
                    $path = 'uploads/applications/' . $this->uploadFile->baseName . '_' . time() . '.' . $this->uploadFile->extension;
                }

                $this->uploadFile->saveAs($path);
                $this->file = $path;
            }
            return true;
        } else {
            return false;
        }
    }
}
