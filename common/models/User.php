<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_INACTIVE = 9;
    public const STATUS_ACTIVE = 10;

    /**
     * @var string|null Password for form handling
     */
    public $password;

    // Roles
    public const ROLE_ADMIN = 10;
    public const ROLE_SUPER_ADMIN = 20;
    public const ROLE_STUDENT = 5;

    // Permissions
    public const PERM_NEWS = 'news';
    public const PERM_APPLICATIONS = 'applications';
    public const PERM_PAGES = 'pages';
    public const PERM_MENUS = 'menus';
    public const PERM_SLIDERS = 'sliders';
    public const PERM_ANNOUNCEMENTS = 'announcements';
    public const PERM_SYMBOLS = 'symbols';
    public const PERM_FOOTER_BLOCKS = 'footer_blocks';
    public const PERM_LOGS = 'logs';
    public const PERM_USERS = 'users';
    public const PERM_MESSAGES = 'messages';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
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
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['role', 'default', 'value' => self::ROLE_STUDENT],
            ['role', 'in', 'range' => [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN, self::ROLE_STUDENT]],
            ['permissions', 'safe'],
            ['password', 'safe'],
        ];
    }

    /**
     * @return bool Whether the user is a super admin
     */
    public function isSuperAdmin()
    {
        return $this->role == self::ROLE_SUPER_ADMIN;
    }

    /**
     * @return array List of permissions
     */
    public function getPermissionsList()
    {
        if (empty($this->permissions)) {
            return [];
        }
        if (is_array($this->permissions)) {
            return $this->permissions;
        }
        $perms = json_decode($this->permissions, true);
        return is_array($perms) ? $perms : [];
    }

    /**
     * Checks if user has a specific permission
     * @param string $permission
     * @return bool
     */
    public function canAccess($permission)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }
        return in_array($permission, $this->getPermissionsList());
    }

    /**
     * @return string Role label
     */
    public function getRoleLabel()
    {
        $roles = [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_SUPER_ADMIN => 'Super Administrator',
        ];
        return $roles[$this->role] ?? 'Unknown';
    }

    /**
     * @return array All available permissions for selection
     */
    public static function getAllPermissions()
    {
        return [
            self::PERM_NEWS => 'News Management',
            self::PERM_APPLICATIONS => 'Applications Support',
            self::PERM_PAGES => 'Content Pages',
            self::PERM_MENUS => 'Navigation & Menus',
            self::PERM_SLIDERS => 'Media Sliders',
            self::PERM_ANNOUNCEMENTS => 'Announcements',
            self::PERM_SYMBOLS => 'University Symbols',
            self::PERM_FOOTER_BLOCKS => 'Footer Blocks',
            self::PERM_LOGS => 'System Audit Logs',
            self::PERM_USERS => 'Staff Management',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->permissions = $this->getPermissionsList();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (is_array($this->permissions)) {
            $this->permissions = json_encode($this->permissions);
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentMessages()
    {
        return $this->hasMany(Message::class, ['sender_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedMessages()
    {
        return $this->hasMany(Message::class, ['receiver_id' => 'id']);
    }
}
