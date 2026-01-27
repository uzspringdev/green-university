<?php

/** @var yii\web\View $this */
/** @var array $sliders */
/** @var array $featuredNews */
/** @var array $latestNews */
/** @var array $announcements */
/** @var array $symbols */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Green University - ' . Yii::t('app', 'Home');
?>

<!-- Hero Slider -->
<div class="hero-slider">
    <?php if (!empty($sliders)): ?>
        <?php foreach ($sliders as $index => $slider): ?>
            <?php $translation = $slider->getTranslation(); ?>
            <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>"
                style="background-image: url('<?= $slider->getImageUrl() ?: '/images/default-slider.jpg' ?>')">
                <div class="hero-overlay">
                    <div class="hero-content container">
                        <h1><?= Html::encode($translation ? $translation->title : 'Green University') ?></h1>
                        <p><?= Html::encode($translation ? $translation->subtitle : Yii::t('app', 'Excellence in Education')) ?>
                        </p>
                        <div class="d-flex gap-3 justify-content-center">
                            <?php if ($slider->link_url): ?>
                                <?= Html::a(
                                    $translation ? $translation->link_text : Yii::t('app', 'Learn More'),
                                    $slider->link_url,
                                    ['class' => 'btn btn-primary px-5']
                                ) ?>
                            <?php endif; ?>
                            <?= Html::a(Yii::t('app', 'Contact Us'), ['/site/contact'], ['class' => 'btn btn-outline-light btn-lg px-5 fw-bold']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="hero-slide active" style="background: var(--gradient-primary)">
            <div class="hero-overlay" style="background: rgba(0,0,0,0.2)">
                <div class="hero-content container">
                    <h1><?= Yii::t('app', 'Welcome to Green University') ?></h1>
                    <p><?= Yii::t('app', 'Building Future Leaders Through Quality Education') ?></p>
                    <div class="d-flex gap-3 justify-content-center">
                        <?= Html::a(Yii::t('app', 'Apply Now'), ['/application/index'], ['class' => 'btn btn-light btn-lg px-5 fw-bold text-success']) ?>
                        <?= Html::a(Yii::t('app', 'Contact Us'), ['/site/contact'], ['class' => 'btn btn-outline-light btn-lg px-5 fw-bold']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Statistics Section -->
<?php if (!empty($symbols)): ?>
    <div class="stats-section">
        <div class="container">
            <div class="row">
                <?php foreach ($symbols as $symbol): ?>
                    <?php $translation = $symbol->getTranslation(); ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-item">
                            <span class="stat-number"><?= Html::encode($symbol->value) ?></span>
                            <span class="stat-label"><?= Html::encode($translation ? $translation->title : '') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Why Choose Us & Video Section -->
<div class="container my-5 py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h2 class="section-title text-start mb-4"><?= Yii::t('app', 'Why Green University?') ?></h2>
            <p class="lead text-muted mb-4">
                <?= Yii::t('app', 'We provide world-class education with a focus on sustainable development and environmental sciences.') ?>
            </p>
            <ul class="list-unstyled mb-5">
                <li class="mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-secondary me-3 fs-5"></i>
                    <span><?= Yii::t('app', 'International curriculum and expert faculty') ?></span>
                </li>
                <li class="mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-secondary me-3 fs-5"></i>
                    <span><?= Yii::t('app', 'State-of-the-art campus and facilities') ?></span>
                </li>
                <li class="mb-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-secondary me-3 fs-5"></i>
                    <span><?= Yii::t('app', 'Strong focus on practical skills and research') ?></span>
                </li>
            </ul>
            <?= Html::a(Yii::t('app', 'Learn More About Us'), ['/site/about'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
        <div class="col-lg-6">
            <div class="position-relative rounded-4 overflow-hidden shadow-lg"
                style="height: 400px; background: var(--gradient-primary);">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/dSxxouqtDwI"
                    title="Green University Campus Tour" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Featured News Section -->
<?php if (!empty($latestNews)): ?>
    <div class="container mt-5 pt-5 pb-2">
        <h2 class="section-title"><?= Yii::t('app', 'Latest News') ?></h2>
        <div class="row">
            <?php foreach (array_slice($latestNews, 0, 3) as $news): ?>
                <?php $translation = $news->getTranslation(); ?>
                <div class="col-md-4 mb-4">
                    <div class="news-card">
                        <div class="position-relative">
                            <?php if ($news->image): ?>
                                <img src="<?= $news->getImageUrl() ?>" class="news-card-image"
                                    alt="<?= Html::encode($translation ? $translation->title : '') ?>">
                            <?php else: ?>
                                <div class="news-card-image d-flex align-items-center justify-content-center bg-light">
                                    <i class="bi bi-image text-muted display-4"></i>
                                </div>
                            <?php endif; ?>
                            <?php
                            $category = $news->category;
                            $categoryTrans = $category ? $category->getTranslation() : null;
                            if ($categoryTrans):
                                ?>
                                <span class="news-card-category position-absolute bottom-0 start-0 m-3 shadow-sm">
                                    <?= Html::encode($categoryTrans->name) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="news-card-body">
                            <h5 class="news-card-title">
                                <?= Html::a(Html::encode($translation ? $translation->title : ''), ['/news/view', 'slug' => $news->slug]) ?>
                            </h5>
                            <p class="news-card-excerpt">
                                <?= Html::encode($translation ? substr(strip_tags($translation->summary), 0, 110) . '...' : '') ?>
                            </p>
                            <div class="news-card-meta">
                                <span><i class="bi bi-calendar3 me-1"></i>
                                    <?= Yii::$app->formatter->asDate($news->published_at) ?></span>
                                <?= Html::a(Yii::t('app', 'Details') . ' <i class="bi bi-arrow-right"></i>', ['/news/view', 'slug' => $news->slug], ['class' => 'text-secondary fw-bold']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3">
            <?= Html::a(Yii::t('app', 'Browse All News'), ['/news/index'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>
<?php endif; ?>

<!-- Announcements Section -->
<div class="container mt-2 pb-5">
    <h2 class="section-title"><?= Yii::t('app', 'Announcements') ?></h2>
    <div class="row">
        <?php if (!empty($announcements)): ?>
            <?php foreach (array_slice($announcements, 0, 3) as $announcement): ?>
                <?php $translation = $announcement->getTranslation(); ?>
                <div class="col-md-4 mb-4">
                    <div class="news-card">
                        <?php if ($announcement->image): ?>
                            <div class="position-relative">
                                <img src="<?= $announcement->getImageUrl() ?>" class="news-card-image"
                                    alt="<?= Html::encode($translation ? $translation->title : '') ?>">
                                <span class="news-card-category position-absolute bottom-0 start-0 m-3">
                                    <?= Yii::t('app', 'ANNOUNCEMENT') ?>
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="news-card-image d-flex align-items-center justify-content-center"
                                style="background: linear-gradient(135deg, #2d8659 0%, #1a5f3e 100%);">
                                <i class="bi bi-megaphone text-white display-4 opacity-50"></i>
                            </div>
                            <span class="news-card-category position-absolute bottom-0 start-0 m-3" style="top: 200px;">
                                <?= Yii::t('app', 'ANNOUNCEMENT') ?>
                            </span>
                        <?php endif; ?>
                        <div class="news-card-body">
                            <h5 class="news-card-title">
                                <?= Html::encode($translation ? $translation->title : '') ?>
                            </h5>
                            <p class="news-card-excerpt">
                                <?= Html::encode($translation ? substr(strip_tags($translation->content), 0, 110) . '...' : '') ?>
                            </p>
                            <div class="news-card-meta">
                                <span><i class="bi bi-calendar3 me-1"></i>
                                    <?= Yii::$app->formatter->asDate($announcement->published_at) ?></span>
                                <a href="<?= Url::to(['/announcement/view', 'slug' => $announcement->slug]) ?>"
                                    class="text-secondary fw-bold">
                                    <?= Yii::t('app', 'Read More') ?> <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted"><?= Yii::t('app', 'No announcements available') ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($announcements)): ?>
        <div class="text-center mt-3">
            <?= Html::a(Yii::t('app', 'Browse All Announcements'), ['/announcement/index'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    <?php endif; ?>
</div>

<!-- CTA Section -->
<div class="stats-section my-0">
    <div class="container text-center py-4">
        <h2 class="mb-4 text-white display-5 fw-bold"><?= Yii::t('app', 'Start Your Journey Today') ?></h2>
        <p class="lead mb-5 text-white opacity-75">
            <?= Yii::t('app', 'Join a community of innovators and leaders at Green University') ?>
        </p>
        <div class="d-flex gap-3 justify-content-center">
            <?= Html::a(Yii::t('app', 'Apply Now'), ['/application/index'], ['class' => 'btn btn-light btn-lg px-5 fw-bold text-success']) ?>
            <?= Html::a(Yii::t('app', 'Inquire'), ['/site/contact'], ['class' => 'btn btn-outline-light btn-lg px-5 fw-bold']) ?>
        </div>
    </div>
</div>

<?php
$this->registerJs("
let slideIndex = 0;
const slides = document.querySelectorAll('.hero-slide');

function showSlides() {
    slides.forEach(slide => slide.classList.remove('active'));
    slideIndex++;
    if (slideIndex >= slides.length) slideIndex = 0;
    slides[slideIndex].classList.add('active');
    setTimeout(showSlides, 6000);
}

if (slides.length > 1) {
    setTimeout(showSlides, 6000);
}
");
?>