<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\NewsTranslation;
use common\models\NewsCategory;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
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
                                return $user && $user->canAccess(\common\models\User::PERM_NEWS);
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
     * Lists all News models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
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
     * Creates a new News model.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new News();
        $model->status = News::STATUS_DRAFT;
        $model->published_at = time();

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
            'categories' => NewsCategory::find()->all(),
        ]);
    }

    /**
     * Updates an existing News model.
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
            'categories' => NewsCategory::find()->all(),
        ]);
    }

    /**
     * Deletes an existing News model.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Delete translations
        NewsTranslation::deleteAll(['news_id' => $id]);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Load and save model with translations
     * @param News $model
     * @return bool
     */
    protected function loadModel($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            // Convert published_at to timestamp if it's a date string
            if ($model->published_at && !is_numeric($model->published_at)) {
                $model->published_at = strtotime($model->published_at);
            }

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                $model->upload();
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    // Determine action type
                    $isNew = $model->isNewRecord;
                    $hasTranslation = false;

                    // Save translations
                    $translations = Yii::$app->request->post('NewsTranslation', []);
                    foreach ($translations as $langId => $data) {
                        // Skip if title is empty
                        if (empty($data['title'])) {
                            continue;
                        }

                        $translation = NewsTranslation::findOne(['news_id' => $model->id, 'language_id' => $langId]);
                        if (!$translation) {
                            $translation = new NewsTranslation();
                            $translation->news_id = $model->id;
                            $translation->language_id = (int) $langId;
                        }
                        $translation->title = $data['title'];
                        $translation->summary = $data['summary'] ?? '';
                        $translation->content = $data['content'] ?? '';
                        if ($translation->save()) {
                            $hasTranslation = true;
                        }
                    }

                    if (!$hasTranslation) {
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('error', 'At least one language must have a Title.');
                        return false;
                    }

                    // Log admin action
                    try {
                        \common\models\AdminLog::log(
                            $isNew ? \common\models\AdminLog::ACTION_CREATE : \common\models\AdminLog::ACTION_UPDATE,
                            get_class($model),
                            $model->id,
                            $isNew ? 'Created new news article' : 'Updated news article'
                        );
                    } catch (\Exception $e) {
                        Yii::error('Admin log failed: ' . $e->getMessage());
                    }

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'News saved successfully.');
                    return true;
                } else {
                    Yii::$app->session->setFlash('error', 'Error saving news: ' . json_encode($model->errors));
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'System error: ' . $e->getMessage());
            }
        }

        return false;
    }

    /**
     * Finds the News model based on its primary key value.
     * @param int $id ID
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
