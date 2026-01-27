<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Announcement $model */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="announcement-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4 text-start">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Announcement:
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Review details and translations of this announcement</p>
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

    <div class="row g-4 text-start">
        <div class="col-lg-8">
            <?php if ($model->image): ?>
                <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                    <div class="card-header bg-transparent py-3 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark small text-uppercase">Featured Image</h5>
                    </div>
                    <div class="card-body p-0">
                        <img src="<?= $model->getImageUrl() ?>" alt="Announcement image" class="img-fluid w-100"
                            style="max-height: 400px; object-fit: cover;">
                    </div>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Translations</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <?php foreach ($model->translations as $translation): ?>
                            <div class="col-12 border-bottom pb-4 mb-4 last-child-border-0">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary rounded-pill me-2 px-3">
                                        <?= strtoupper($translation->language->code) ?>
                                    </span>
                                    <h5 class="fw-bold mb-0 text-dark">
                                        <?= Html::encode($translation->title) ?>
                                    </h5>
                                </div>
                                <div class="text-muted lh-lg">
                                    <?= nl2br(Html::encode($translation->content)) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Information</h5>
                    <?php
                    $isPublished = $model->status == \common\models\Announcement::STATUS_PUBLISHED;
                    ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isPublished ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isPublished ? 'Published' : 'Draft' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-link-45deg me-2 text-primary"></i> Slug</span>
                            <span class="fw-bold font-monospace bg-light p-1 px-2 rounded small">
                                <?= $model->slug ?>
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-calendar-event me-2 text-primary"></i>
                                Published</span>
                            <span class="fw-medium">
                                <?= date('d M Y, H:i', $model->published_at) ?>
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-clock me-2 text-primary"></i> Created</span>
                            <span class="fw-medium">
                                <?= date('d M Y, H:i', $model->created_at) ?>
                            </span>
                        </div>
                        <div
                            class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted"><i class="bi bi-arrow-repeat me-2 text-primary"></i> Updated</span>
                            <span class="fw-medium">
                                <?= date('d M Y, H:i', $model->updated_at) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body p-4 text-start">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-lightbulb fs-3 text-info"></i>
                        <h6 class="mb-0 fw-bold">Note</h6>
                    </div>
                    <p class="small text-muted mb-0">Announcements are displayed on the frontend based on the
                        <strong>Published At</strong> date. Change status to Draft to hide it immediately.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>