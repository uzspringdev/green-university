<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Application;

use yii\web\UploadedFile;

/**
 * ApplicationController handles admission applications
 */
class ApplicationController extends Controller
{
    /**
     * Display application form
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Application();

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if (!Yii::$app->user->isGuest) {
                $model->user_id = Yii::$app->user->id;
            }
            if ($model->upload() && $model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your application has been submitted successfully.'));
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Submit application via AJAX
     * 
     * @return mixed
     */
    public function actionSubmit()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Application();

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
            if (!Yii::$app->user->isGuest) {
                $model->user_id = Yii::$app->user->id;
            }
            if ($model->upload() && $model->save(false)) {
                return [
                    'success' => true,
                    'message' => Yii::t('app', 'Your application has been submitted successfully.'),
                ];
            }
        }

        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }
}
