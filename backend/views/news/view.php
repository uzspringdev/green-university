<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\News $model */

$this->title = 'View News: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Article Details & Performance</p>
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
            <!-- Translations -->
            <h5 class="fw-bold mb-3 text-muted small text-uppercase">Article Content</h5>
            <?php foreach ($model->translations as $translation): ?>
                <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                    <div class="card-header bg-light py-3 border-0 d-flex align-items-center justify-content-between">
                        <span class="badge bg-white shadow-sm text-dark px-3 py-2 rounded-pill small">
                            <i class="bi bi-translate me-1 text-primary"></i> <?= $translation->language->name ?>
                        </span>
                        <small class="text-muted fst-italic">Last updated:
                            <?= date('d M Y, H:i', $model->updated_at) ?></small>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark mb-3"><?= Html::encode($translation->title) ?></h4>
                        <div class="bg-light p-3 rounded mb-4 border-start border-4 border-primary">
                            <p class="mb-0 text-secondary small fw-medium"><?= Html::encode($translation->summary) ?></p>
                        </div>
                        <div class="content-text text-muted line-height-lg">
                            <?= nl2br(Html::encode($translation->content)) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-4">
            <!-- Media Preview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Cover Image</h5>
                </div>
                <div class="card-body text-center p-3">
                    <?php if ($model->image): ?>
                        <?= Html::img($model->getImageUrl(), ['class' => 'img-fluid rounded shadow-sm border mb-2 w-100', 'style' => 'object-fit: cover; max-height: 250px;']) ?>
                        <div class="small text-muted font-monospace"><?= $model->image ?></div>
                    <?php else: ?>
                        <div class="bg-light rounded py-5 border">
                            <i class="bi bi-image fs-1 text-muted opacity-25"></i>
                            <div class="text-muted small">No image uploaded</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Metadata Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">At a Glance</h5>
                    <?php
                    $isPublished = $model->status == \common\models\News::STATUS_PUBLISHED;
                    echo Html::tag('span', $isPublished ? 'Live' : 'Draft', [
                        'class' => 'badge rounded-pill ' . ($isPublished ? 'bg-success bg-opacity-10 text-success px-3' : 'bg-warning bg-opacity-10 text-dark px-3')
                    ]);
                    ?>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-collection me-2 text-primary"></i> Category</span>
                            <span
                                class="fw-bold"><?= $model->category ? ($model->category->getTranslation('uz')->name ?? $model->category->getTranslation('en')->name ?? 'N/A') : 'N/A' ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-eye me-2 text-primary"></i> Total Views</span>
                            <span
                                class="fw-bold badge bg-light text-dark rounded-pill px-3"><?= number_format($model->views) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-star me-2 text-primary"></i> Featured</span>
                            <span><?= $model->is_featured ? '<i class="bi bi-check-circle-fill text-success"></i> Yes' : '<i class="bi bi-x-circle text-muted"></i> No' ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-calendar-event me-2 text-primary"></i> Publish
                                Date</span>
                            <span class="fw-medium"><?= date('d M Y, H:i', $model->published_at) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-link-45deg me-2 text-primary"></i> URL Slug</span>
                            <span class="small font-monospace bg-light p-1 px-2 rounded"><?= $model->slug ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-3 small text-muted">
                    <div class="mb-2"><strong>ID:</strong> #<?= $model->id ?></div>
                    <div class="mb-2"><strong>Created:</strong> <?= date('d M Y, H:i', $model->created_at) ?></div>
                    <div><strong>Modified:</strong> <?= date('d M Y, H:i', $model->updated_at) ?></div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .line-height-lg {
        line-height: 1.8;
    }

    .extra-small {
        font-size: 0.75rem;
    }

    .content-text {
        font-size: 0.95rem;
    }
</style>