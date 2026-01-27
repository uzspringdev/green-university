<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\News;
use common\models\NewsCategory;

/**
 * NewsController handles news display
 */
class NewsController extends Controller
{
    /**
     * Lists all published news
     * 
     * @param int|null $category
     * @return mixed
     */
    public function actionIndex($category = null)
    {
        $query = News::findPublished();

        if ($category !== null) {
            $query->andWhere(['category_id' => $category]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        $categories = NewsCategory::findActive()->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'selectedCategory' => $category,
        ]);
    }

    /**
     * Displays a single news article
     * 
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $news = News::findPublished()
            ->andWhere(['slug' => $slug])
            ->one();

        if ($news === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested news does not exist.'));
        }

        // Increment views
        $news->incrementViews();

        $translation = $news->getTranslation(Yii::$app->language);

        // Get related news
        $relatedNews = News::findPublished()
            ->andWhere(['!=', 'news.id', $news->id])
            ->andWhere(['category_id' => $news->category_id])
            ->limit(3)
            ->all();

        return $this->render('view', [
            'model' => $news,
            'translation' => $translation,
            'relatedNews' => $relatedNews,
        ]);
    }
}
