<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Page $page */
/** @var common\models\PageTranslation $translation */

$this->title = $translation ? $translation->title : '';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-view py-5">
    <div class="row">
        <div class="col-lg-8">
            <article>
                <h1 class="mb-4">
                    <?= Html::encode($this->title) ?>
                </h1>

                <div class="content">
                    <?= $translation ? $translation->content : '' ?>
                </div>
            </article>
        </div>
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px;">
                <?php if (!empty($latestNews)): ?>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0"><?= Yii::t('app', 'Latest News') ?></h5>
                        </div>
                        <div class="card-body px-0">
                            <div class="list-group list-group-flush">
                                <?php foreach ($latestNews as $news): ?>
                                    <?php $newsTrans = $news->getTranslation(); ?>
                                    <a href="<?= \yii\helpers\Url::to(['/news/view', 'slug' => $news->slug]) ?>"
                                        class="list-group-item list-group-item-action px-4 py-3 border-0">
                                        <h6 class="mb-1 text-dark"><?= Html::encode($newsTrans ? $newsTrans->title : '') ?></h6>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            <?= Yii::$app->formatter->asDate($news->published_at) ?>
                                        </small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>