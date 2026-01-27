<?php

namespace backend\controllers;

use Yii;
use common\models\MenuItem;
use common\models\MenuItemTranslation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuItemController implements the CRUD actions for MenuItem model.
 */
class MenuItemController extends Controller
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
                        'sort' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Resorts the menu items based on the new hierarchical order from AJAX.
     */
    public function actionSort()
    {
        $items = Yii::$app->request->post('items');
        if (!empty($items)) {
            foreach ($items as $item) {
                $id = $item['id'] ?? null;
                if ($id) {
                    $model = MenuItem::findOne($id);
                    if ($model) {
                        $model->sort_order = (int) ($item['sort_order'] ?? 0);
                        $model->parent_id = !empty($item['parent_id']) ? (int) $item['parent_id'] : null;
                        $model->save(false);
                    }
                }
            }
            return json_encode(['success' => true]);
        }
        return json_encode(['success' => false]);
    }

    /**
     * Creates a new MenuItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($menu_id)
    {
        $model = new MenuItem();
        $model->menu_id = $menu_id;
        $model->status = MenuItem::STATUS_ACTIVE;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                // Save translations
                $translations = Yii::$app->request->post('MenuItemTranslation', []);
                foreach ($translations as $langId => $data) {
                    if (empty($data['title']))
                        continue;

                    $translation = new MenuItemTranslation();
                    $translation->menu_item_id = $model->id;
                    $translation->language_id = (int) $langId;
                    $translation->title = $data['title'];
                    $translation->save();
                }

                return $this->redirect(['/menu/view', 'id' => $model->menu_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            // Save translations
            $translations = Yii::$app->request->post('MenuItemTranslation', []);
            foreach ($translations as $langId => $data) {
                $translation = MenuItemTranslation::findOne(['menu_item_id' => $model->id, 'language_id' => $langId]);
                if (!$translation) {
                    $translation = new MenuItemTranslation();
                    $translation->menu_item_id = $model->id;
                    $translation->language_id = (int) $langId;
                }
                $translation->title = $data['title'] ?? '';
                $translation->save();
            }

            return $this->redirect(['/menu/view', 'id' => $model->menu_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $menuId = $model->menu_id;
        $model->delete();

        return $this->redirect(['/menu/view', 'id' => $menuId]);
    }

    /**
     * Finds the MenuItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MenuItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuItem::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
