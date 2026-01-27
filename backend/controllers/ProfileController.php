<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the profile view and management for the logged-in admin.
 */
class ProfileController extends Controller
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
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays the current user's profile.
     * @return string
     */
    public function actionIndex()
    {
        $model = Yii::$app->user->identity;
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Updates the current user's profile.
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        /** @var User $model */
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Profile updated successfully.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
