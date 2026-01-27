<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\Announcement;

/**
 * AnnouncementController handles announcements display
 */
class AnnouncementController extends Controller
{
    /**
     * Lists all published announcements
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Announcement::findPublished(),
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_at' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single announcement
     * 
     * @param string $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Announcement::findPublished()
            ->andWhere(['slug' => $slug])
            ->one();

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested announcement does not exist.'));
        }

        $translation = $model->getTranslation(Yii::$app->language);

        $otherAnnouncements = Announcement::findPublished()
            ->andWhere(['!=', 'announcement.id', $model->id])
            ->limit(5)
            ->all();

        return $this->render('view', [
            'model' => $model,
            'translation' => $translation,
            'otherAnnouncements' => $otherAnnouncements,
        ]);
    }
}
