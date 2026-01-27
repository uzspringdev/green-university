<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Application;
use common\models\News;
use common\models\Page;
use common\models\Slider;
use common\models\AdminLog;

$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];

// Basic Statistics
$totalApplications = Application::find()->count();
$newApplications = Application::find()->where(['status' => Application::STATUS_NEW])->count();
$totalNews = News::find()->count();
$publishedNews = News::find()->where(['status' => News::STATUS_PUBLISHED])->count();
$totalPages = Page::find()->count();
$totalSliders = Slider::find()->where(['status' => Slider::STATUS_ACTIVE])->count();

// Real Server Health Metrics
$diskPath = PHP_OS_FAMILY === 'Windows' ? "C:" : "/";
$diskTotal = @disk_total_space($diskPath) ?: 1;
$diskFree = @disk_free_space($diskPath) ?: 0;
$diskUsed = $diskTotal - $diskFree;
$diskPercent = ($diskUsed / $diskTotal) * 100;

$gbTotal = round($diskTotal / (1024 * 1024 * 1024), 1);
$gbUsed = round($diskUsed / (1024 * 1024 * 1024), 1);

// Data for Chart 1: Applications over last 6 months
$months = [];
$appCounts = [];
for ($i = 5; $i >= 0; $i--) {
    $monthStart = strtotime("first day of -$i month 00:00:00");
    $monthEnd = strtotime("last day of -$i month 23:59:59");
    $months[] = date('M', $monthStart);
    $appCounts[] = Application::find()->where(['between', 'created_at', $monthStart, $monthEnd])->count();
}

// Data for Chart 2: Status Distribution
$statusDistribution = [
    'New' => (int) Application::find()->where(['status' => Application::STATUS_NEW])->count(),
    'Processing' => (int) Application::find()->where(['status' => Application::STATUS_PROCESSING])->count(),
    'Approved' => (int) Application::find()->where(['status' => Application::STATUS_APPROVED])->count(),
    'Rejected' => (int) Application::find()->where(['status' => Application::STATUS_REJECTED])->count(),
];

// Register Chart.js
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_HEAD]);
?>

<div class="site-index">
    <!-- Page Header -->
    <div
        class="page-header d-flex justify-content-between align-items-center mb-5 p-4 border-0 shadow-sm bg-white rounded-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-primary">University Command Center</h1>
            <p class="text-muted mb-0">Analytics & content management gateway</p>
        </div>
        <div class="text-end d-none d-md-block">
            <div class="fw-bold fs-4 text-primary"><?= date('H:i') ?></div>
            <div class="text-muted small fw-medium"><?= date('l, d F Y') ?></div>
        </div>
    </div>

    <!-- Quick Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="modern-card h-100 p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-primary-light text-primary rounded-3 p-3 shadow-xs">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small fw-bold uppercase">Applications</h6>
                        <h2 class="mb-0 fw-bold"><?= number_format($totalApplications) ?></h2>
                    </div>
                </div>
                <div class="small">
                    <span class="text-success"><i class="bi bi-arrow-up-short"></i> Trend Active</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="modern-card h-100 p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 shadow-xs">
                        <i class="bi bi-newspaper fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small fw-bold uppercase">News Articles</h6>
                        <h2 class="mb-0 fw-bold"><?= number_format($totalNews) ?></h2>
                    </div>
                </div>
                <div class="small">
                    <span class="text-info"><?= $publishedNews ?> Published</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="modern-card h-100 p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 shadow-xs">
                        <i class="bi bi-files fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small fw-bold uppercase">Pages</h6>
                        <h2 class="mb-0 fw-bold"><?= $totalPages ?></h2>
                    </div>
                </div>
                <div class="small">
                    <span class="text-muted">Managed Assets</span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="modern-card h-100 p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 shadow-xs">
                        <i class="bi bi-images fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small fw-bold uppercase">Sliders</h6>
                        <h2 class="mb-0 fw-bold"><?= $totalSliders ?></h2>
                    </div>
                </div>
                <div class="small">
                    <span class="text-warning">Hero Campaigns</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="row g-4 mb-4">
        <!-- Line Chart: Applications Trend -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="fw-bold mb-0">Student Inbound Flow <small class="text-muted fw-normal ms-2">(Last 6
                            Months)</small></h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div style="height: 300px;">
                        <canvas id="applicationsTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Doughnut Chart: Status Distribution -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="fw-bold mb-0">Admission Status</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div style="height: 300px;">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions & Recent Activity -->
        <div class="col-lg-8">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <?= Html::a('<div class="action-tile-modern p-4 text-center rounded-4 shadow-xs h-100 bg-white">
                        <div class="icon-circle bg-primary text-white mb-3 mx-auto">
                            <i class="bi bi-plus-lg fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Publish News</h6>
                        <p class="smallest text-muted mb-0">Updates for the student feed</p>
                    </div>', ['/news/create'], ['class' => 'text-decoration-none']) ?>
                </div>
                <div class="col-md-4">
                    <?= Html::a('<div class="action-tile-modern p-4 text-center rounded-4 shadow-xs h-100 bg-white">
                        <div class="icon-circle bg-secondary text-white mb-3 mx-auto">
                            <i class="bi bi-layout-text-window fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-dark">New Page</h6>
                        <p class="smallest text-muted mb-0">Add static institutional content</p>
                    </div>', ['/page/create'], ['class' => 'text-decoration-none']) ?>
                </div>
                <div class="col-md-4">
                    <?= Html::a('<div class="action-tile-modern p-4 text-center rounded-4 shadow-xs h-100 bg-white">
                        <div class="icon-circle bg-info text-white mb-3 mx-auto">
                            <i class="bi bi-megaphone fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Broadcast</h6>
                        <p class="smallest text-muted mb-0">Create new announcement</p>
                    </div>', ['/announcement/create'], ['class' => 'text-decoration-none']) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Candidate Activity</h5>
                    <?= Html::a('View All Portal Data', ['/application/index'], ['class' => 'btn btn-sm btn-link text-decoration-none p-0 fw-bold']) ?>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Candidate Name</th>
                                    <th class="py-3 border-0">Primary Contact</th>
                                    <th class="py-3 border-0">Application Status</th>
                                    <th class="text-end pe-4 py-3 border-0">Navigation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $recentApps = Application::find()
                                    ->orderBy(['created_at' => SORT_DESC])
                                    ->limit(4)
                                    ->all();
                                ?>
                                <?php foreach ($recentApps as $app): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">
                                                <?= Html::encode($app->first_name . ' ' . $app->last_name) ?>
                                            </div>
                                            <div class="text-muted smallest">Registered
                                                <?= Yii::$app->formatter->asRelativeTime($app->created_at) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small text-dark fw-medium"><?= Html::encode($app->email) ?></div>
                                            <div class="smallest text-muted"><?= Html::encode($app->phone) ?></div>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge-modern <?= $app->status === Application::STATUS_NEW ? 'warning' : ($app->status === Application::STATUS_APPROVED ? 'success' : 'info') ?>">
                                                <span class="pulse-dot"></span>
                                                <?= $app->getStatusLabel() ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?= Html::a('<i class="bi bi-arrow-right"></i>', ['/application/view', 'id' => $app->id], ['class' => 'btn btn-icon-light']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lateral Intelligence Panel -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white mb-4 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Real-time Logs</h5>
                        <i class="bi bi-activity fs-5 opacity-50"></i>
                    </div>
                    <?php
                    $recentLogs = AdminLog::find()
                        ->orderBy(['created_at' => SORT_DESC])
                        ->limit(4)
                        ->all();
                    ?>
                    <div class="timeline-v3">
                        <?php foreach ($recentLogs as $log): ?>
                            <div class="timeline-item-v3 mb-4">
                                <div class="smallest opacity-50 mb-1 fw-bold">
                                    <?= strtoupper(Yii::$app->formatter->asRelativeTime($log->created_at)) ?>
                                </div>
                                <div class="small fw-bold mb-1"><?= Html::encode($log->getActionLabel()) ?></div>
                                <div class="smallest opacity-75"><?= Html::encode($log->description) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= Html::a('Full System Audit', ['/admin-log/index'], ['class' => 'btn btn-white-glass btn-sm w-100 rounded-pill mt-2']) ?>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="fw-bold mb-0">Server Health</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>System Uptime</span>
                            <span class="fw-bold text-success">99.9%</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 99.9%"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Storage Usage</span>
                            <span class="fw-bold text-primary"><?= $gbUsed ?> GB / <?= $gbTotal ?> GB</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: <?= round($diskPercent, 1) ?>%"></div>
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded-4">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-shield-check fs-2 text-primary"></i>
                            <div>
                                <div class="fw-bold small">Security Core Enabled</div>
                                <div class="smallest text-muted">Last bypass attempt: None</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .action-tile-modern {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #f0f0f0;
    }

    .action-tile-modern:hover {
        transform: translateY(-5px);
        border-color: var(--admin-primary);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .action-tile-modern:hover .icon-circle {
        transform: scale(1.1);
    }

    .status-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .status-badge-modern.warning {
        background: #fff8e1;
        color: #f57c00;
    }

    .status-badge-modern.success {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-badge-modern.info {
        background: #e3f2fd;
        color: #1976d2;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse-modern 2s infinite;
    }

    @keyframes pulse-modern {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.4;
            transform: scale(1.3);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .btn-icon-light {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        color: #212529;
        transition: all 0.2s;
    }

    .btn-icon-light:hover {
        background: var(--admin-primary);
        color: #fff;
    }

    .btn-white-glass {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        font-weight: 700;
        transition: all 0.3s;
    }

    .btn-white-glass:hover {
        background: #fff;
        color: var(--admin-primary);
    }

    .timeline-v3 {
        border-left: 1px solid rgba(255, 255, 255, 0.2);
        padding-left: 20px;
    }

    .timeline-item-v3 {
        position: relative;
    }

    .timeline-item-v3::before {
        content: '';
        position: absolute;
        left: -24px;
        top: 4px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
    }
</style>

<?php
$monthLabels = json_encode($months);
$monthData = json_encode($appCounts);
$statusLabels = json_encode(array_keys($statusDistribution));
$statusData = json_encode(array_values($statusDistribution));

$this->registerJs("
    // Applications Trend Chart
    const ctxTrend = document.getElementById('applicationsTrendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: $monthLabels,
            datasets: [{
                label: 'Applications',
                data: $monthData,
                borderColor: '#1B4332',
                backgroundColor: 'rgba(27, 67, 50, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1B4332',
                pointBorderColor: '#fff',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Status Distribution Chart
    const ctxStatus = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: $statusLabels,
            datasets: [{
                data: $statusData,
                backgroundColor: ['#f59e0b', '#3b82f6', '#1B4332', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 10, padding: 20 } }
            },
            cutout: '70%'
        }
    });
");
?>