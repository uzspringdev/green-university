<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\models\User;
use common\models\News;
use common\models\Application;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php $this->head() ?>
</head>

<body class="admin-body">
    <?php $this->beginBody() ?>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <?= Html::img('@web/images/logo.svg', ['alt' => 'Green University', 'class' => 'sidebar-logo']) ?>
            <p class="text-white fw-bold mb-0">Green University</p>
        </div>

        <nav class="sidebar-menu">
            <?php
            /** @var \common\models\User $user */
            $user = Yii::$app->user->identity;

            $showContent = $user->canAccess(User::PERM_NEWS) ||
                $user->canAccess(User::PERM_PAGES) ||
                $user->canAccess(User::PERM_ANNOUNCEMENTS);

            $showSiteSetup = $user->canAccess(User::PERM_MENUS) ||
                $user->canAccess(User::PERM_SLIDERS) ||
                $user->canAccess(User::PERM_SYMBOLS) ||
                $user->canAccess(User::PERM_FOOTER_BLOCKS);

            $showSystem = $user->canAccess(User::PERM_APPLICATIONS) ||
                $user->canAccess(User::PERM_USERS) ||
                $user->canAccess(User::PERM_LOGS);
            ?>
            <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>"
                class="menu-item <?= Yii::$app->controller->id === 'site' ? 'active' : '' ?>">
                <span class="menu-icon"><i class="bi bi-speedometer2"></i></span>
                <span class="menu-label">Dashboard</span>
            </a>

            <?php if ($showContent): ?>
                <div class="menu-section">Content</div>

                <?php if ($user->canAccess(User::PERM_NEWS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/news/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'news' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-newspaper"></i></span>
                        <span class="menu-label">News</span>
                    </a>

                    <a href="<?= \yii\helpers\Url::to(['/news-category/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'news-category' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-folder"></i></span>
                        <span class="menu-label">Categories</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_PAGES)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/page/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'page' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-file-earmark-text"></i></span>
                        <span class="menu-label">Pages</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_ANNOUNCEMENTS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/announcement/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'announcement' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-megaphone"></i></span>
                        <span class="menu-label">Announcements</span>
                    </a>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($showSiteSetup): ?>
                <div class="menu-section">Site Setup</div>

                <?php if ($user->canAccess(User::PERM_MENUS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/menu/index']) ?>"
                        class="menu-item <?= in_array(Yii::$app->controller->id, ['menu', 'menu-item']) ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-list"></i></span>
                        <span class="menu-label">Menus</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_SLIDERS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/slider/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'slider' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-images"></i></span>
                        <span class="menu-label">Sliders</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_SYMBOLS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/symbol/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'symbol' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-patch-check"></i></span>
                        <span class="menu-label">University Symbols</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_FOOTER_BLOCKS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/footer-block/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'footer-block' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-layout-sidebar-reverse"></i></span>
                        <span class="menu-label">Footer Blocks</span>
                    </a>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($showSystem): ?>
                <div class="menu-section">System</div>

                <?php if ($user->canAccess(User::PERM_APPLICATIONS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/application/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'application' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-journal-check"></i></span>
                        <span class="menu-label">Applications</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_USERS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/user/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'user' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-people-fill"></i></span>
                        <span class="menu-label">Staff Management</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_LOGS)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/admin-log/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'admin-log' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-clock-history"></i></span>
                        <span class="menu-label">Activity Logs</span>
                    </a>
                <?php endif; ?>

                <?php if ($user->canAccess(User::PERM_MESSAGES)): ?>
                    <a href="<?= \yii\helpers\Url::to(['/message/index']) ?>"
                        class="menu-item <?= Yii::$app->controller->id === 'message' ? 'active' : '' ?>">
                        <span class="menu-icon"><i class="bi bi-chat-dots-fill"></i></span>
                        <span class="menu-label">Support Chat</span>
                    </a>
                <?php endif; ?>

            <?php endif; ?>

            <a href="http://localhost:8080" target="_blank" class="menu-item">
                <span class="menu-icon"><i class="bi bi-eye"></i></span>
                <span class="menu-label">View Frontend</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <?php if (!Yii::$app->user->isGuest): ?>
                <?php /** @var \common\models\User $user */ $user = Yii::$app->user->identity; ?>
                <div class="user-info">
                    <?= Html::a('<div class="user-avatar">' . strtoupper(substr($user->username, 0, 2)) . '</div>', ['/profile/index'], ['class' => 'text-decoration-none']) ?>
                    <div class="user-details">
                        <?= Html::a('<div class="user-name">' . Html::encode($user->username) . '</div>', ['/profile/index'], ['class' => 'text-decoration-none text-white']) ?>
                        <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                        <?= Html::submitButton('Logout', ['class' => 'btn-logout']) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-content" id="adminContent">
        <!-- Top Bar -->
        <header class="admin-topbar">
            <button class="sidebar-toggle" id="sidebarToggle">☰</button>
            <h5 class="mb-0"><?= Html::encode($this->title) ?></h5>
            <div class="topbar-actions">
                <span class="text-muted small"><?= date('Y-m-d H:i') ?></span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="admin-main">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <div class="container-fluid">
                <span class="text-muted">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></span>
                <span class="float-end text-muted">Powered by Yii <?= Yii::getVersion() ?></span>
            </div>
        </footer>
    </div>

    <?php
    $this->registerJs("
const sidebar = document.getElementById('adminSidebar');
const content = document.getElementById('adminContent');
const toggle = document.getElementById('sidebarToggle');

toggle.addEventListener('click', function() {
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('expanded');
    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
});


// Restore sidebar state
if (localStorage.getItem('sidebarCollapsed') === 'true') {
    sidebar.classList.add('collapsed');
    content.classList.add('expanded');
}

// Fallback for data-method='post' if yii.js isn't catching it
document.addEventListener('click', function(e) {
    const target = e.target.closest('a[data-method=\"post\"]');
    if (target) {
        e.preventDefault();
        const confirmMsg = target.getAttribute('data-confirm');
        if (confirmMsg && !confirm(confirmMsg)) {
            return false;
        }

        const url = target.getAttribute('href');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfParam = document.querySelector('meta[name=\"csrf-param\"]');
        const csrfToken = document.querySelector('meta[name=\"csrf-token\"]');
        
        if (csrfParam && csrfToken) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = csrfParam.content;
            input.value = csrfToken.content;
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }
});
");
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage(); ?>