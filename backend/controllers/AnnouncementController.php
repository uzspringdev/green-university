<?php

namespace backend\controllers;

use Yii;
use common\models\Announcement;
use common\models\AnnouncementTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * AnnouncementController implements the CRUD actions for Announcement model.
 */
class AnnouncementController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                /** @var \common\models\User $user */
                                $user = Yii::$app->user->identity;
                                return $user && $user->canAccess(\common\models\User::PERM_ANNOUNCEMENTS);
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Announcement models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Announcement::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Announcement model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Announcement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Announcement();
        $model->status = Announcement::STATUS_PUBLISHED;
        $model->published_at = time();

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Updates an existing Announcement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Deletes an existing Announcement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        AnnouncementTranslation::deleteAll(['announcement_id' => $id]);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Announcement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Announcement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Announcement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Shared logic for loading and saving translations
     */
    protected function loadModel($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            // Handle date conversion for published_at if needed
            if ($model->published_at && !is_numeric($model->published_at)) {
                $model->published_at = strtotime($model->published_at);
            }

            // Handle image upload
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                $model->upload();
            }

            if ($model->save()) {
                $translations = Yii::$app->request->post('AnnouncementTranslation', []);
                foreach ($translations as $langId => $data) {
                    $translation = AnnouncementTranslation::findOne([
                        'announcement_id' => $model->id,
                        'language_id' => $langId
                    ]);
                    if (!$translation) {
                        $translation = new AnnouncementTranslation();
                        $translation->announcement_id = $model->id;
                        $translation->language_id = $langId;
                    }
                    $translation->title = $data['title'] ?? '';
                    $translation->content = $data['content'] ?? '';
                    $translation->save();
                }
                return true;
            }
        }
        return false;
    }
}
