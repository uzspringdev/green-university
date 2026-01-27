<?php

namespace backend\controllers;

use Yii;
use common\models\Page;
use common\models\PageTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{
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
                                return $user && $user->canAccess(\common\models\User::PERM_PAGES);
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Page();
        $model->status = Page::STATUS_ACTIVE;

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        PageTranslation::deleteAll(['page_id' => $id]);
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function loadModel($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Save translations
            $translations = Yii::$app->request->post('PageTranslation', []);
            foreach ($translations as $langId => $data) {
                $translation = PageTranslation::findOne(['page_id' => $model->id, 'language_id' => $langId]);
                if (!$translation) {
                    $translation = new PageTranslation();
                    $translation->page_id = $model->id;
                    $translation->language_id = $langId;
                }
                $translation->title = $data['title'] ?? '';
                $translation->content = $data['content'] ?? '';
                $translation->meta_description = $data['meta_description'] ?? '';
                $translation->meta_keywords = $data['meta_keywords'] ?? '';
                $translation->save();
            }

            Yii::$app->session->setFlash('success', 'Page saved successfully.');
            return true;
        }

        return false;
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
