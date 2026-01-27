<?php

namespace backend\controllers;

use Yii;
use common\models\Symbol;
use common\models\SymbolTranslation;
use common\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * SymbolController implements the CRUD actions for Symbol model.
 */
class SymbolController extends Controller
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
                                return $user && $user->canAccess(\common\models\User::PERM_SYMBOLS);
                            }
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'sort' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Symbol models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Symbol::find()->orderBy(['sort_order' => SORT_ASC]),
            'pagination' => false, // Disable pagination for easy sorting
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Symbol model.
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
     * Creates a new Symbol model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Symbol();
        $model->status = Symbol::STATUS_ACTIVE;

        if ($this->loadModel($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'languages' => Language::getActiveLanguages(),
        ]);
    }

    /**
     * Updates an existing Symbol model.
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
     * Deletes an existing Symbol model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        SymbolTranslation::deleteAll(['symbol_id' => $id]);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Resorts the symbols based on the new order from AJAX.
     */
    public function actionSort()
    {
        $items = Yii::$app->request->post('items');
        if (!empty($items)) {
            foreach ($items as $index => $id) {
                $model = Symbol::findOne($id);
                if ($model) {
                    $model->sort_order = $index + 1;
                    $model->save(false);
                }
            }
            return json_encode(['success' => true]);
        }
        return json_encode(['success' => false]);
    }

    /**
     * Finds the Symbol model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Symbol the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Symbol::findOne(['id' => $id])) !== null) {
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
                $translations = Yii::$app->request->post('SymbolTranslation', []);
                foreach ($translations as $langId => $data) {
                    $translation = SymbolTranslation::findOne([
                        'symbol_id' => $model->id,
                        'language_id' => $langId
                    ]);
                    if (!$translation) {
                        $translation = new SymbolTranslation();
                        $translation->symbol_id = $model->id;
                        $translation->language_id = $langId;
                    }
                    $translation->title = $data['title'] ?? '';
                    $translation->save();
                }
                return true;
            }
        }
        return false;
    }
}
