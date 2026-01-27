<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Page;

/**
 * PageController handles dynamic pages
 */
class PageController extends Controller
{
    /**
     * Display a page by slug
     * 
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $page = Page::findActive()
            ->andWhere(['slug' => $slug])
            ->one();

        if ($page === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $translation = $page->getTranslation(Yii::$app->language);
        $latestNews = \common\models\News::findPublished()->limit(5)->all();

        return $this->render('view', [
            'page' => $page,
            'translation' => $translation,
            'latestNews' => $latestNews,
        ]);
    }
}
