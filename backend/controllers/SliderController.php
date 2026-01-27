<?php

namespace backend\controllers;

use Yii;
use common\models\Slider;
use common\models\SliderTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

/**
 * SliderController implements the CRUD actions for Slider model.
 */
class SliderController extends Controller
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
                                return $user && $user->canAccess(\common\models\User::PERM_SLIDERS);
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST', 'GET'],
                        'sort' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Resorts the sliders based on the new order from AJAX.
     */
    public function actionSort()
    {
        $items = Yii::$app->request->post('items');
        if (!empty($items)) {
            foreach ($items as $index => $id) {
                $model = Slider::findOne($id);
                if ($model) {
                    $model->sort_order = $index + 1;
                    $model->save(false);
                }
            }
            return json_encode(['success' => true]);
        }
        return json_encode(['success' => false]);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Slider::find()->orderBy(['sort_order' => SORT_ASC]),
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
        $model = new Slider();
        $model->status = Slider::STATUS_ACTIVE;

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
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = $this->findModel($id);
            SliderTranslation::deleteAll(['slider_id' => $id]);
            $model->delete();
            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error('Slider delete failed: ' . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Error deleting slider: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function loadModel($model)
    {
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                $model->upload();
            }

            if ($model->save()) {
                // Save translations
                $translations = Yii::$app->request->post('SliderTranslation', []);
                foreach ($translations as $langId => $data) {
                    $translation = SliderTranslation::findOne(['slider_id' => $model->id, 'language_id' => $langId]);
                    if (!$translation) {
                        $translation = new SliderTranslation();
                        $translation->slider_id = $model->id;
                        $translation->language_id = $langId;
                    }
                    $translation->title = $data['title'] ?? '';
                    $translation->subtitle = $data['subtitle'] ?? '';
                    $translation->link_text = $data['link_text'] ?? '';
                    $translation->save();
                }

                Yii::$app->session->setFlash('success', 'Slider saved successfully.');
                return true;
            } else {
                Yii::error('Slider save failed: ' . json_encode($model->errors));
            }
        }


        return false;
    }

    protected function findModel($id)
    {
        if (($model = Slider::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
