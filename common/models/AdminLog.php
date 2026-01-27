<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "admin_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string|null $model
 * @property int|null $model_id
 * @property string|null $description
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property int $created_at
 *
 * @property User $user
 */
class AdminLog extends ActiveRecord
{
    // Action constants
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_CREATE = 'create';
    const ACTION_UPDATE = 'update';
    const ACTION_DELETE = 'delete';
    const ACTION_VIEW = 'view';
    const ACTION_STATUS_CHANGE = 'status_change';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'action'], 'required'],
            [['user_id', 'model_id', 'created_at'], 'integer'],
            [['description', 'user_agent'], 'string'],
            [['action'], 'string', 'max' => 50],
            [['model'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'action' => 'Action',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'description' => 'Description',
            'ip_address' => 'IP Address',
            'user_agent' => 'User Agent',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Log an action
     */
    public static function log($action, $model = null, $modelId = null, $description = null)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $log = new static();
        $log->user_id = Yii::$app->user->id;
        $log->action = $action;
        $log->model = $model;
        $log->model_id = $modelId;
        $log->description = $description;
        $log->ip_address = Yii::$app->request->userIP;
        $log->user_agent = Yii::$app->request->userAgent;

        return $log->save();
    }

    /**
     * Get action label
     */
    public function getActionLabel()
    {
        $labels = [
            self::ACTION_LOGIN => 'Login',
            self::ACTION_LOGOUT => 'Logout',
            self::ACTION_CREATE => 'Create',
            self::ACTION_UPDATE => 'Update',
            self::ACTION_DELETE => 'Delete',
            self::ACTION_VIEW => 'View',
            self::ACTION_STATUS_CHANGE => 'Status Change',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    /**
     * Get model label
     */
    public function getModelLabel()
    {
        if (!$this->model) {
            return null;
        }

        $parts = explode('\\', $this->model);
        return end($parts);
    }

    /**
     * Get action badge class
     */
    public function getActionBadgeClass()
    {
        $classes = [
            self::ACTION_LOGIN => 'badge-success',
            self::ACTION_LOGOUT => 'badge-secondary',
            self::ACTION_CREATE => 'badge-primary',
            self::ACTION_UPDATE => 'badge-info',
            self::ACTION_DELETE => 'badge-danger',
            self::ACTION_VIEW => 'badge-light',
            self::ACTION_STATUS_CHANGE => 'badge-warning',
        ];

        return $classes[$this->action] ?? 'badge-secondary';
    }
}
