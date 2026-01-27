<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\Application;
use common\models\Message;
use common\models\User;

/**
 * Dashboard controller for students
 */
class DashboardController extends Controller
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
                            return $identity->role == User::ROLE_STUDENT;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays student dashboard.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $applications = Application::find()->where(['user_id' => $userId])->orderBy(['id' => SORT_DESC])->all();

        // 1. Find my conversation
        $participant = \common\models\ChatParticipant::find()->where(['user_id' => $userId])->one();

        $messages = [];
        if ($participant) {
            $conversation = $participant->conversation;
            $messages = $conversation->getChatMessages()->orderBy(['created_at' => SORT_ASC])->all();
        }

        return $this->render('index', [
            'applications' => $applications,
            'messages' => $messages,
        ]);
    }

    public function actionSendMessage()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $text = Yii::$app->request->post('message');
        $userId = Yii::$app->user->id;

        if (empty($text)) {
            return ['success' => false, 'error' => 'Message cannot be empty'];
        }

        // Find or Create Conversation
        $participant = \common\models\ChatParticipant::find()->where(['user_id' => $userId])->one();

        if ($participant) {
            $conversation = $participant->conversation;
        } else {
            // Check if user already has conversation but somehow missing participant record? Unlikely.
            // Create new private conversation
            $conversation = new \common\models\ChatConversation();
            $conversation->type = \common\models\ChatConversation::TYPE_PRIVATE;
            if (!$conversation->save()) {
                return ['success' => false, 'error' => 'Failed to start conversation'];
            }

            $p = new \common\models\ChatParticipant();
            $p->conversation_id = $conversation->id;
            $p->user_id = $userId;
            $p->joined_at = time();
            $p->save();
        }

        $message = new \common\models\ChatMessage();
        $message->conversation_id = $conversation->id;
        $message->sender_id = $userId;
        $message->message = $text;

        if ($message->save()) {
            $conversation->touch('updated_at'); // Bring to top for admins
            return [
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'text' => \yii\helpers\Html::encode($message->message),
                    'time' => date('H:i', $message->created_at),
                    'is_mine' => true
                ]
            ];
        }

        return ['success' => false, 'error' => 'Failed to send message'];
    }

    public function actionGetMessages($lastId = 0)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $userId = Yii::$app->user->id;

        $participant = \common\models\ChatParticipant::find()->where(['user_id' => $userId])->one();
        if (!$participant) {
            return ['success' => true, 'messages' => []];
        }

        $messages = \common\models\ChatMessage::find()
            ->where(['conversation_id' => $participant->conversation_id])
            ->andWhere(['>', 'id', $lastId])
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $result = [];
        foreach ($messages as $msg) {
            $result[] = [
                'id' => $msg->id,
                'text' => \yii\helpers\Html::encode($msg->message),
                'time' => date('H:i', $msg->created_at),
                'is_mine' => $msg->sender_id == $userId,
                //'sender_name' => $msg->sender->username 
            ];
        }

        return ['success' => true, 'messages' => $result];
    }
}
