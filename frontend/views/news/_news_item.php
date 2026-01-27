<?php

use yii\helpers\Html;

/** @var common\models\News $model */

$translation = $model->getTranslation();
$category = $model->category;
$categoryTrans = $category ? $category->getTranslation() : null;
?>

<div class="news-card h-100">
    <div class="position-relative">
        <?php if ($model->image): ?>
            <img src="<?= $model->getImageUrl() ?>" class="news-card-image"
                alt="<?= Html::encode($translation ? $translation->title : '') ?>">
        <?php else: ?>
            <div class="news-card-image d-flex align-items-center justify-content-center bg-light">
                <i class="bi bi-image text-muted opacity-25 display-4"></i>
            </div>
        <?php endif; ?>

        <?php if ($categoryTrans): ?>
            <span class="news-card-category position-absolute bottom-0 start-0 m-3 shadow-sm">
                <?= Html::encode($categoryTrans->name) ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="news-card-body">
        <h5 class="news-card-title mb-3">
            <?= Html::a(Html::encode($translation ? $translation->title : ''), ['/news/view', 'slug' => $model->slug]) ?>
        </h5>

        <p class="news-card-excerpt">
            <?= Html::encode(\yii\helpers\StringHelper::truncate(strip_tags($translation->summary ?? ''), 120)) ?>
        </p>

        <div class="news-card-meta mt-4">
            <span class="small"><i class="bi bi-calendar3 me-1"></i>
                <?= Yii::$app->formatter->asDate($model->published_at) ?></span>
            <?= Html::a(Yii::t('app', 'Read Article') . ' <i class="bi bi-arrow-right ms-1"></i>', ['/news/view', 'slug' => $model->slug], ['class' => 'text-secondary fw-bold text-decoration-none small']) ?>
        </div>
    </div>
</div>