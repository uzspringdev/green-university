<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_messages".
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $sender_id
 * @property string $message
 * @property int $is_read
 * @property int $created_at
 *
 * @property ChatConversation $conversation
 * @property User $sender
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
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
            [['conversation_id', 'sender_id', 'message'], 'required'],
            [['conversation_id', 'sender_id', 'is_read', 'created_at'], 'integer'],
            [['message'], 'string'],
            [['conversation_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatConversation::class, 'targetAttribute' => ['conversation_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Conversation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConversation()
    {
        return $this->hasOne(ChatConversation::class, ['id' => 'conversation_id']);
    }

    /**
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }
}
