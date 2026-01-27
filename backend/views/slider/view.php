<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'View Slider: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Hero Carousel Slide Details</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil me-1"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'confirm' => 'Are you sure?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Slide Image</h5>
                </div>
                <div class="card-body p-0 text-center bg-light">
                    <?php if ($model->image): ?>
                        <?= Html::img($model->getImageUrl(), ['class' => 'img-fluid shadow-sm', 'style' => 'max-height: 400px; width: 100%; object-fit: cover;']) ?>
                    <?php else: ?>
                        <div class="py-5 text-muted">
                            <i class="bi bi-image fs-1 opacity-25 d-block mb-2"></i>
                            <span>No image uploaded</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-muted small text-uppercase">Slide Translations</h5>
            <?php foreach ($model->translations as $translation): ?>
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                        <span class="badge bg-light text-dark px-3 py-2 rounded-pill small border">
                            <i class="bi bi-translate me-1 text-primary"></i> <?= $translation->language->name ?>
                        </span>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <h4 class="fw-bold text-dark mb-2"><?= Html::encode($translation->title) ?></h4>
                        <p class="text-muted mb-3 fs-5"><?= Html::encode($translation->subtitle) ?></p>

                        <?php if ($translation->link_text): ?>
                            <div
                                class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-primary bg-opacity-10 text-primary rounded-pill small fw-bold">
                                <?= Html::encode($translation->link_text) ?> <i class="bi bi-arrow-right"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Configuration</h5>
                    <?php
                    $isActive = $model->status == \common\models\Slider::STATUS_ACTIVE;
                    ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-sort-numeric-down me-2 text-primary"></i> Sort
                                Order</span>
                            <span class="fw-bold"><?= $model->sort_order ?></span>
                        </div>
                        <div class="list-group-item py-3">
                            <div class="text-muted mb-2"><i class="bi bi-link-45deg me-2 text-primary"></i> Target URL
                            </div>
                            <?php if ($model->link_url): ?>
                                <a href="<?= $model->link_url ?>" target="_blank"
                                    class="text-primary text-break font-monospace small"><?= $model->link_url ?></a>
                            <?php else: ?>
                                <span class="text-muted small italic">No external link</span>
                            <?php endif; ?>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-hash me-2 text-primary"></i> Slider ID</span>
                            <span class="fw-bold text-muted">#<?= $model->id ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-light border">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <i class="bi bi-lightbulb fs-3 text-primary opacity-50"></i>
                        <h6 class="mb-0 fw-bold">Tip</h6>
                    </div>
                    <p class="small text-muted mb-0">Use high-resolution images (min 1920x800px) for the best appearance
                        on the homepage carousel.</p>
                </div>
            </div>
        </div>
    </div>
</div>