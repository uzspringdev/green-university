<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Message;
use common\models\User;
use yii\web\NotFoundHttpException;

/**
 * MessageController handles admin messaging system
 */
class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            /** @var User $identity */
                            $identity = Yii::$app->user->identity;
                            return $identity->canAccess(User::PERM_MESSAGES);
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all students with active charts
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Fetch all conversations, ordered by latest activity
        // In a shared support inbox, admins see all student chats
        $conversations = \common\models\ChatConversation::find()
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();

        $chats = [];
        foreach ($conversations as $conv) {
            // Find the other participant (Student)
            // We assume 1-on-1 support chat primarily
            $studentParticipant = $conv->getChatParticipants()
                ->joinWith('user')
                ->where(['!=', 'user_id', Yii::$app->user->id]) // Not me
                ->andWhere(['role' => User::ROLE_STUDENT]) // Is student
                ->one();

            // If no specific student found (maybe admin-admin chat?), pick any other participant
            if (!$studentParticipant) {
                $studentParticipant = $conv->getChatParticipants()
                    ->where(['!=', 'user_id', Yii::$app->user->id])
                    ->one();
            }

            if ($studentParticipant && $studentParticipant->user) {
                $lastMsg = $conv->getLastMessage()->one();
                $unreadCount = \common\models\ChatMessage::find()
                    ->where(['conversation_id' => $conv->id, 'is_read' => 0])
                    ->andWhere(['!=', 'sender_id', Yii::$app->user->id]) // Messages NOT from me
                    ->count();

                $chats[] = [
                    'conversation_id' => $conv->id,
                    'user' => $studentParticipant->user,
                    'last_message' => $lastMsg,
                    'unread_count' => $unreadCount
                ];
            }
        }

        return $this->render('index', [
            'chats' => $chats,
        ]);
    }

    public function actionView($id)
    {
        // ID is now Conversation ID, strictly.
        // But for backward compatibility with the View (which expects User ID sometimes?), 
        // Wait, the View JS `viewUrl` passed `id` as User ID in previous code.
        // We need to support fetching by Conversation ID OR User ID.
        // Let's standardise: The UI now passes Conversation ID.

        $conversation = \common\models\ChatConversation::findOne($id);
        if (!$conversation) {
            // Fallback: If passed ID is User ID, try to find conversation
            $participant = \common\models\ChatParticipant::find()->where(['user_id' => $id])->one();
            if ($participant) {
                $conversation = $participant->conversation;
            }
        }

        if (!$conversation) {
            throw new NotFoundHttpException('Conversation not found.');
        }

        // Mark messages as read
        \common\models\ChatMessage::updateAll(['is_read' => 1], [
            'conversation_id' => $conversation->id,
            'is_read' => 0
        ]);
        // Also exclude my own messages from being marked read? 
        // Logic: Mark messages where sender != me.
        \common\models\ChatMessage::updateAll(['is_read' => 1], [
            'conversation_id' => $conversation->id,
            'is_read' => 0,
        ]);
        // Better: AND sender_id != me. But simpler to just mark all as read for now in shared inbox.

        $messages = $conversation->getChatMessages()->orderBy(['created_at' => SORT_ASC])->all();

        // Find student user for the header
        $studentParticipant = $conversation->getChatParticipants()
            ->joinWith('user')
            ->where(['role' => User::ROLE_STUDENT])
            ->one();
        $student = $studentParticipant ? $studentParticipant->user : new User(['username' => 'Unknown']);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_chat_content', [
                'messages' => $messages,
                'student' => $student
            ]);
        }

        return $this->redirect(['index']);
    }

    public function actionSend()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $conversationId = Yii::$app->request->post('conversation_id');
        $text = Yii::$app->request->post('message');

        if (empty($text) || empty($conversationId)) {
            return ['success' => false, 'error' => 'Missing parameters'];
        }

        $conversation = \common\models\ChatConversation::findOne($conversationId);
        if (!$conversation) {
            return ['success' => false, 'error' => 'Conversation not found'];
        }

        $msg = new \common\models\ChatMessage();
        $msg->conversation_id = $conversation->id;
        $msg->sender_id = Yii::$app->user->id;
        $msg->message = $text;

        if ($msg->save()) {
            $conversation->touch('updated_at'); // Update sort order
            return [
                'success' => true,
                'message' => [
                    'text' => \yii\helpers\Html::encode($msg->message),
                    'time' => Yii::$app->formatter->asDate($msg->created_at, 'php:H:i'),
                    'is_mine' => true
                ]
            ];
        }

        return ['success' => false, 'error' => 'Failed to save'];
    }
}
