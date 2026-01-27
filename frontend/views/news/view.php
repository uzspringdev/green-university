<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\News $model */
/** @var array $latestNews */

$translation = $model->getTranslation();
$this->title = $translation ? $translation->title : 'News';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-view container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <article class="news-post">
                <header class="mb-5">
                    <?php if ($model->category): ?>
                        <?php $catTrans = $model->category->getTranslation(); ?>
                        <span class="news-card-category mb-3"><?= Html::encode($catTrans ? $catTrans->name : '') ?></span>
                    <?php endif; ?>

                    <h1 class="display-5 fw-bold text-primary mb-4"><?= Html::encode($this->title) ?></h1>

                    <div class="d-flex align-items-center gap-4 text-muted small border-bottom pb-4 mb-4">
                        <span><i class="bi bi-calendar3 me-1 text-secondary"></i>
                            <?= Yii::$app->formatter->asDate($model->published_at) ?></span>
                        <span><i class="bi bi-eye me-1 text-secondary"></i> <?= $model->views ?>
                            <?= Yii::t('app', 'views') ?></span>
                        <div class="ms-auto d-flex gap-2">
                            <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-telegram"></i></a>
                            <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="bi bi-link-45deg"></i></a>
                        </div>
                    </div>
                </header>

                <?php if ($model->image): ?>
                    <div class="mb-5 rounded-4 overflow-hidden shadow-sm">
                        <img src="<?= $model->getImageUrl() ?>" class="img-fluid w-100"
                            alt="<?= Html::encode($this->title) ?>">
                    </div>
                <?php endif; ?>

                <div class="news-content fs-5 lh-lg text-dark">
                    <?= $translation ? $translation->content : '' ?>
                </div>

                <div class="mt-5 pt-5 border-top">
                    <h4 class="fw-bold mb-4 text-primary"><?= Yii::t('app', 'Share this update') ?></h4>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary rounded-pill px-4"><i class="bi bi-facebook me-2"></i>
                            Facebook</button>
                        <button class="btn btn-info text-white rounded-pill px-4"><i class="bi bi-telegram me-2"></i>
                            Telegram</button>
                        <button class="btn btn-outline-secondary rounded-pill px-4"><i
                                class="bi bi-link-45deg me-2"></i> Copy Link</button>
                    </div>
                </div>
            </article>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-primary mb-4"><?= Yii::t('app', 'Recent Stories') ?></h5>
                        <?php if (!empty($latestNews)): ?>
                            <?php foreach (array_slice($latestNews, 0, 5) as $recent): ?>
                                <?php if ($recent->id === $model->id)
                                    continue; ?>
                                <?php $recentTrans = $recent->getTranslation(); ?>
                                <div class="mb-4 pb-4 border-bottom last-child-border-0">
                                    <h6 class="fw-bold mb-2">
                                        <?= Html::a(Html::encode($recentTrans ? $recentTrans->title : ''), ['view', 'slug' => $recent->slug], ['class' => 'text-dark text-decoration-none hover-secondary']) ?>
                                    </h6>
                                    <span class="small text-muted"><i class="bi bi-calendar3 me-1"></i>
                                        <?= Yii::$app->formatter->asDate($recent->published_at) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?= Html::a(Yii::t('app', 'See all news') . ' <i class="bi bi-arrow-right"></i>', ['index'], ['class' => 'btn btn-light w-100 rounded-pill fw-bold text-primary']) ?>
                    </div>
                </div>

                <div class="card bg-primary text-white border-0 rounded-4 overflow-hidden shadow-sm">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-envelope-check display-4 mb-3 opacity-50"></i>
                        <h5 class="fw-bold mb-3"><?= Yii::t('app', 'Stay Informed') ?></h5>
                        <p class="small opacity-75 mb-4">
                            <?= Yii::t('app', 'Subscribe to our newsletter for the latest academic news and campus events.') ?>
                        </p>
                        <div class="input-group">
                            <input type="email" class="form-control border-0 rounded-start-pill ps-3"
                                placeholder="Enter your email">
                            <button class="btn btn-light rounded-end-pill px-3"><i
                                    class="bi bi-send-fill text-primary"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .last-child-border-0:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .hover-secondary:hover {
        color: var(--secondary-green) !important;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 1rem;
        margin: 2rem 0;
        box-shadow: var(--shadow-sm);
    }
</style>