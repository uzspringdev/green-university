<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_conversations".
 *
 * @property int $id
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ChatMessage[] $chatMessages
 * @property ChatParticipant[] $chatParticipants
 */
class ChatConversation extends \yii\db\ActiveRecord
{
    const TYPE_PRIVATE = 1;
    const TYPE_GROUP = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_conversations';
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
            [['type'], 'integer'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * Gets query for [[ChatMessages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::class, ['conversation_id' => 'id']);
    }

    /**
     * Gets query for [[ChatParticipants]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChatParticipants()
    {
        return $this->hasMany(ChatParticipant::class, ['conversation_id' => 'id']);
    }

    public function getLastMessage()
    {
        return $this->hasOne(ChatMessage::class, ['conversation_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
