<?php

namespace backend\controllers;

use Yii;
use common\models\NewsCategory;
use common\models\NewsCategoryTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\AdminLog;

/**
 * NewsCategoryController implements the CRUD actions for NewsCategory model.
 */
class NewsCategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all NewsCategory models.
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => NewsCategory::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NewsCategory model.
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
     * Creates a new NewsCategory model.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new NewsCategory();
        $model->status = NewsCategory::STATUS_ACTIVE;

        if ($this->loadModel($model)) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Updates an existing NewsCategory model.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->loadModel($model)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Deletes an existing NewsCategory model.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Delete translations
        NewsCategoryTranslation::deleteAll(['category_id' => $id]);

        $model->delete();

        // Log
        try {
            AdminLog::log(AdminLog::ACTION_DELETE, get_class($model), $id, 'Deleted news category');
        } catch (\Exception $e) {
        }

        return $this->redirect(['index']);
    }

    /**
     * Load and save model with translations
     * @param NewsCategory $model
     * @return bool
     */
    protected function loadModel($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $isNew = $model->isNewRecord; // Actually isNewRecord is false after save, need to check before

            // Save translations
            $translations = Yii::$app->request->post('NewsCategoryTranslation', []);
            foreach ($translations as $langId => $data) {
                $translation = NewsCategoryTranslation::findOne(['category_id' => $model->id, 'language_id' => $langId]);
                if (!$translation) {
                    $translation = new NewsCategoryTranslation();
                    $translation->category_id = $model->id;
                    $translation->language_id = $langId;
                }
                $translation->name = $data['name'] ?? '';
                $translation->save();
            }

            // Log
            try {
                AdminLog::log(
                    Yii::$app->controller->action->id == 'create' ? AdminLog::ACTION_CREATE : AdminLog::ACTION_UPDATE,
                    get_class($model),
                    $model->id,
                    Yii::$app->controller->action->id == 'create' ? 'Created news category' : 'Updated news category'
                );
            } catch (\Exception $e) {
            }

            Yii::$app->session->setFlash('success', 'Category saved successfully.');
            return true;
        }

        return false;
    }

    /**
     * Finds the NewsCategory model based on its primary key value.
     * @param int $id ID
     * @return NewsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewsCategory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
