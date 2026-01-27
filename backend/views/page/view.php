<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Page: ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Dynamic Page Details & Content</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil me-1"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <h5 class="fw-bold mb-3 text-muted small text-uppercase">Page Translations</h5>
            <?php foreach ($model->translations as $translation): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light py-3 border-0 d-flex align-items-center justify-content-between">
                        <span class="badge bg-white shadow-sm text-dark px-3 py-2 rounded-pill small">
                            <i class="bi bi-translate me-1 text-primary"></i> <?= $translation->language->name ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark mb-3"><?= Html::encode($translation->title) ?></h4>
                        <div class="content-text text-muted line-height-lg mb-4">
                            <?= nl2br(Html::encode($translation->content)) ?>
                        </div>

                        <?php if ($translation->meta_description): ?>
                            <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-info">
                                <div class="small fw-bold text-info text-uppercase mb-1">SEO Description</div>
                                <div class="small text-muted"><?= Html::encode($translation->meta_description) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Page Info</h5>
                    <?php
                    $isActive = $model->status == \common\models\Page::STATUS_ACTIVE;
                    ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-link-45deg me-2 text-primary"></i> URL Slug</span>
                            <span class="fw-bold font-monospace bg-light p-1 px-2 rounded"><?= $model->slug ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-hash me-2 text-primary"></i> Page ID</span>
                            <span class="fw-bold">#<?= $model->id ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-calendar-plus me-2 text-primary"></i>
                                Created</span>
                            <span class="fw-medium font-monospace"><?= date('d M Y, H:i', $model->created_at) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-clock-history me-2 text-primary"></i> Last
                                Updated</span>
                            <span class="fw-medium font-monospace"><?= date('d M Y, H:i', $model->updated_at) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-eye fs-3 text-primary opacity-50"></i>
                        <h6 class="mb-0 fw-bold">Live View</h6>
                    </div>
                    <p class="small text-muted mb-3">You can view this page on the frontend website to see how it looks
                        for visitors.</p>
                    <a href="http://localhost:8080/page/<?= Html::encode($model->slug) ?>" target="_blank"
                        class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                        Open Frontend <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>