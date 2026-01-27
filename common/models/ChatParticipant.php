<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chat_participants".
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $user_id
 * @property int $joined_at
 *
 * @property ChatConversation $conversation
 * @property User $user
 */
class ChatParticipant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_participants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conversation_id', 'user_id'], 'required'],
            [['conversation_id', 'user_id', 'joined_at'], 'integer'],
            [['conversation_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChatConversation::class, 'targetAttribute' => ['conversation_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
