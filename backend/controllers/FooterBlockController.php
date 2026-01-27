<?php

namespace backend\controllers;

use Yii;
use common\models\FooterBlock;
use common\models\FooterBlockTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * FooterBlockController implements the CRUD actions for FooterBlock model.
 */
class FooterBlockController extends Controller
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
                                return $user && $user->canAccess(\common\models\User::PERM_FOOTER_BLOCKS);
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
     * Lists all FooterBlock models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FooterBlock::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FooterBlock model.
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
     * Creates a new FooterBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FooterBlock();
        $model->status = FooterBlock::STATUS_ACTIVE;

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Updates an existing FooterBlock model.
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
     * Deletes an existing FooterBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        FooterBlockTranslation::deleteAll(['footer_block_id' => $id]);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FooterBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FooterBlock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FooterBlock::findOne(['id' => $id])) !== null) {
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
            if ($model->save()) {
                $translations = Yii::$app->request->post('FooterBlockTranslation', []);
                foreach ($translations as $langId => $data) {
                    $translation = FooterBlockTranslation::findOne([
                        'footer_block_id' => $model->id,
                        'language_id' => $langId
                    ]);
                    if (!$translation) {
                        $translation = new FooterBlockTranslation();
                        $translation->footer_block_id = $model->id;
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
