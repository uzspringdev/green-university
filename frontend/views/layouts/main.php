<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\models\Menu;
use common\models\Language;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <div class="top-bar">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="contact-info small">
                    <span class="me-3"><i class="bi bi-telephone-fill me-1"></i> +998 55 512 00 77</span>
                    <span><i class="bi bi-envelope-fill me-1"></i> info@greenuniversity.uz</span>
                </div>
                <div class="social-icons small d-none d-sm-block">
                    <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-telegram"></i></a>
                </div>

                <div class="d-none d-sm-flex align-items-center ms-3">
                    <?php
                    // Top Bar Language Selector (Desktop - Dropdown)
                    $currentLang = Yii::$app->language;
                    $langs = \common\models\Language::getActiveLanguages();
                    ?>
                    <div class="dropdown">
                        <a class="dropdown-toggle text-decoration-none text-white small fw-bold opacity-75 hover-opacity-100"
                            href="#" role="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-globe2 me-1"></i> <?= strtoupper($currentLang) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                            aria-labelledby="langDropdown" style="min-width: 150px;">
                            <?php foreach ($langs as $lang): ?>
                                <li>
                                    <a class="dropdown-item small py-2 d-flex align-items-center <?= $currentLang === $lang->code ? 'active bg-light text-primary fw-bold' : '' ?>"
                                        href="<?= Url::to(['/site/language', 'lang' => $lang->code]) ?>">
                                        <span
                                            class="fi fi-<?= $lang->code === 'en' ? 'gb' : $lang->code ?> me-2 rounded-1"></span><?= $lang->name ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light navbar-modern sticky-top bg-white">
            <div class="container">
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                    <?= Html::img('@web/images/logo.svg', ['alt' => 'Green University']) ?>
                </a>

                <div class="navbar-utilities d-flex align-items-center ms-auto gap-2 order-lg-last">
                    <?php
                    // Language selector (Minimal)
                    $languages = Language::getActiveLanguages();
                    $currentLang = Yii::$app->language;

                    $flagMap = [
                        'uz' => 'uz',
                        'ru' => 'ru',
                        'en' => 'gb',
                    ];

                    $nameMap = [
                        'uz' => "O'zbekcha",
                        'en' => "English",
                        'ru' => "Русский",
                    ];

                    $dropdownItems = [];
                    foreach ($languages as $lang) {
                        $flagCode = isset($flagMap[$lang->code]) ? $flagMap[$lang->code] : $lang->code;
                        $fullName = isset($nameMap[$lang->code]) ? $nameMap[$lang->code] : $lang->name;

                        $dropdownItems[] = [
                            'label' => '<span class="fi fi-' . $flagCode . ' me-2 rounded-1"></span>' . $fullName,
                            'url' => ['/site/language', 'lang' => $lang->code],
                            'active' => $currentLang === $lang->code,
                            'encode' => false,
                        ];
                    }

                    $currentFlag = isset($flagMap[$currentLang]) ? $flagMap[$currentLang] : $currentLang;

                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav d-flex flex-row d-lg-none'], // Visible only on Mobile
                        'items' => [
                            [
                                'label' => '<span class="fi fi-' . $currentFlag . ' rounded-1"></span>',
                                'encode' => false,
                                'items' => $dropdownItems,
                                'options' => ['class' => 'nav-item dropdown language-selector'],
                                'linkOptions' => ['class' => 'nav-link dropdown-toggle text-dark fw-bold small', 'data-bs-toggle' => 'dropdown', 'title' => isset($nameMap[$currentLang]) ? $nameMap[$currentLang] : $currentLang],
                            ],
                        ],
                    ]);

                    // Vertical Separator (Hide on mobile since lang selector is there, show on desktop)
                    echo '<div class="mx-2 d-none d-lg-block" style="width: 1px; height: 24px; background-color: #dee2e6;"></div>';

                    // Auth Buttons Group
                    echo '<div class="d-flex align-items-center gap-2">';
                    if (Yii::$app->user->isGuest) {
                        // Desktop: Login Text + Register Button
                        echo Html::a(Yii::t('app', 'Login'), ['/site/login'], ['class' => 'btn btn-link text-decoration-none text-dark fw-bold small px-2 d-none d-lg-block']);
                        echo Html::a(Yii::t('app', 'Register'), ['/site/signup'], ['class' => 'btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold d-none d-lg-block']);

                        // Mobile: Login Icon
                        echo Html::a('<div class="bg-primary-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-person-fill text-primary fs-5"></i></div>', ['/site/login'], ['class' => 'text-decoration-none d-lg-none']);
                    } else {
                        $user = Yii::$app->user->identity;
                        echo Nav::widget([
                            'options' => ['class' => 'navbar-nav flex-row'],
                            'items' => [
                                [
                                    'label' => '<div class="bg-primary-light rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-person text-primary fs-5"></i></div>',
                                    'encode' => false,
                                    'items' => [
                                        [
                                            'label' => '<i class="bi bi-person me-2"></i> ' . Yii::t('app', 'Profile'),
                                            'url' => ['/dashboard/index'],
                                            'encode' => false,
                                        ],
                                        '<div class="dropdown-divider"></div>',
                                        [
                                            'label' => '<i class="bi bi-power me-2 text-danger"></i> ' . Yii::t('app', 'Logout'),
                                            'url' => ['/site/logout'],
                                            'linkOptions' => [
                                                'data-method' => 'post',
                                                'class' => 'text-danger fw-bold dropdown-item',
                                            ],
                                            'encode' => false,
                                        ],
                                    ],
                                    'options' => ['class' => 'nav-item dropdown profile-dropdown'],
                                    'linkOptions' => ['class' => 'nav-link dropdown-toggle d-flex align-items-center text-dark p-0', 'data-bs-toggle' => 'dropdown'],
                                ],
                            ],
                        ]);
                    }
                    echo '</div>';
                    ?>
                </div>

                <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <?php
                    // Get main menu items - dynamic from database
                    $menu = Menu::findByCode('main-menu');
                    $menuItems = [];

                    if ($menu && $menu->rootItems) {
                        foreach ($menu->rootItems as $item) {
                            $translation = $item->getTranslation();
                            $label = $translation ? $translation->title : $item->url;

                            if ($item->hasChildren()) {
                                $subItems = [];
                                foreach ($item->children as $child) {
                                    $childTrans = $child->getTranslation();
                                    $subItems[] = [
                                        'label' => $childTrans ? $childTrans->title : $child->url,
                                        'url' => $child->url,
                                    ];
                                }

                                $menuItems[] = [
                                    'label' => $label,
                                    'items' => $subItems,
                                    'options' => ['class' => 'nav-item dropdown'],
                                    'linkOptions' => ['class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown'],
                                ];
                            } else {
                                $menuItems[] = [
                                    'label' => $label,
                                    'url' => $item->url,
                                ];
                            }
                        }
                    } else {
                        // Default menu items
                        $menuItems = [
                            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
                            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
                            ['label' => Yii::t('app', 'News'), 'url' => ['/news/index']],
                            ['label' => Yii::t('app', 'Announcements'), 'url' => ['/announcement/index']],
                            ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                        ];
                    }

                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-lg-0'],
                        'items' => $menuItems,
                    ]);
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <?php if (!in_array(Yii::$app->controller->route, ['site/index'])): ?>
            <div class="container my-5 pt-4">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => ['class' => 'breadcrumb mb-4 rounded-pill bg-light px-4 py-2 small shadow-sm']
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        <?php else: ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        <?php endif; ?>
    </main>

    <footer class="footer-modern mt-auto">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-4 text-white">Green University</h5>
                    <p class="opacity-75 mb-4">
                        <?= Yii::t('app', 'Empowering students to build a sustainable future through innovation and environmental excellence.') ?>
                    </p>
                    <div class="social-icons d-flex gap-2">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-telegram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-2">
                    <h5 class="fw-bold mb-4 text-white"><?= Yii::t('app', 'Explore') ?></h5>
                    <a href="<?= Url::to(['/site/about']) ?>" class="footer-link"><?= Yii::t('app', 'About Us') ?></a>
                    <a href="<?= Url::to(['/news/index']) ?>"
                        class="footer-link"><?= Yii::t('app', 'Latest News') ?></a>
                    <a href="<?= Url::to(['/site/contact']) ?>" class="footer-link"><?= Yii::t('app', 'Contact') ?></a>
                </div>
                <div class="col-md-2">
                    <h5 class="fw-bold mb-4 text-white"><?= Yii::t('app', 'Portal') ?></h5>
                    <a href="<?= Url::to(['/application/index']) ?>"
                        class="footer-link"><?= Yii::t('app', 'Apply Now') ?></a>
                    <a href="<?= Url::to(['/announcement/index']) ?>"
                        class="footer-link"><?= Yii::t('app', 'Announcements') ?></a>
                    <a href="<?= Url::to(['/dashboard/index']) ?>"
                        class="footer-link"><?= Yii::t('app', 'Student Portal') ?></a>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-4 text-white"><?= Yii::t('app', 'Get in Touch') ?></h5>
                    <div class="d-flex gap-3 mb-3 opacity-75">
                        <i class="bi bi-geo-alt fs-5 text-secondary"></i>
                        <span>123 Academic Way, Green District, Tashkent, Uzbekistan</span>
                    </div>
                    <div class="d-flex gap-3 mb-3 opacity-75">
                        <i class="bi bi-telephone fs-5 text-secondary"></i>
                        <span>+998 55 512 00 77</span>
                    </div>
                    <div class="d-flex gap-3 opacity-75">
                        <i class="bi bi-envelope fs-5 text-secondary"></i>
                        <span>admissions@greenuniversity.uz</span>
                    </div>
                </div>
            </div>
            <hr class="border-white opacity-10 my-5">
            <div
                class="footer-bottom-info d-flex flex-column flex-md-row justify-content-between align-items-center small opacity-50">
                <p class="mb-2 mb-md-0">&copy; <?= date('Y') ?>
                    <?= Yii::t('app', 'Green University Uzbekistan. Empowering Sustainable Futures.') ?>
                </p>
                <div class="d-flex gap-4">
                    <a href="#" class="text-white text-decoration-none"><?= Yii::t('app', 'Privacy Policy') ?></a>
                    <a href="#" class="text-white text-decoration-none"><?= Yii::t('app', 'Terms of Service') ?></a>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
