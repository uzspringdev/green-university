<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $categories */
/** @var int|null $selectedCategory */

$this->title = Yii::t('app', 'Latest News');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-index container py-5">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p><?= Yii::t('app', 'Discover the latest updates, stories, and academic achievements from Green University.') ?>
        </p>
    </div>

    <!-- Category Filter -->
    <?php if (!empty($categories)): ?>
        <div class="category-filter">
            <h5 class="fw-bold mb-4 text-primary text-uppercase small letter-spacing-1">
                <?= Yii::t('app', 'Browse Categories') ?></h5>
            <div class="d-flex flex-wrap gap-2">
                <?= Html::a(Yii::t('app', 'All Updates'), ['/news/index'], [
                    'class' => $selectedCategory === null ? 'category-btn active' : 'category-btn'
                ]) ?>
                <?php foreach ($categories as $category): ?>
                    <?php $translation = $category->getTranslation(); ?>
                    <?= Html::a(
                        Html::encode($translation ? $translation->name : ''),
                        ['/news/index', 'category' => $category->id],
                        ['class' => $selectedCategory == $category->id ? 'category-btn active' : 'category-btn']
                    ) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_news_item',
        'layout' => '<div class="row g-4">{items}</div><div class="mt-5">{pager}</div>',
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination mt-5'],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '<i class="bi bi-chevron-left"></i>',
            'nextPageLabel' => '<i class="bi bi-chevron-right"></i>',
        ]
    ]) ?>
</div>