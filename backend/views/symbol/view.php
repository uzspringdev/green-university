<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Symbol $model */

$this->title = 'Symbol Details';
$this->params['breadcrumbs'][] = ['label' => 'Symbols', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="symbol-view mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Review university symbol details and indicators</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil me-1"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this symbol?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Translations</h5>
                </div>
                <div class="card-body p-4 text-start">
                    <div class="row g-4">
                        <?php foreach ($model->translations as $translation): ?>
                            <div class="col-md-4">
                                <div class="p-3 border rounded-4 text-center h-100 shadow-sm bg-light bg-opacity-50">
                                    <span class="badge bg-primary rounded-pill mb-2 px-3"><?= strtoupper($translation->language->code) ?></span>
                                    <h6 class="fw-bold text-dark mb-0"><?= Html::encode($translation->title) ?></h6>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom text-start">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Visual Preview</h5>
                </div>
                <div class="card-body p-5 text-center">
                    <div class="d-inline-flex flex-column align-items-center p-4 rounded-5 border bg-white shadow" style="min-width: 200px;">
                        <i class="<?= Html::encode($model->icon ?: 'bi bi-app') ?> fs-1 text-primary mb-3"></i>
                        <h2 class="display-6 fw-bold text-dark mb-1"><?= Html::encode($model->value) ?></h2>
                        <span class="text-muted"><?= Html::encode($model->getTranslation()->title ?? 'Sample Title') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden text-start">
                <div class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Status</h5>
                    <?php
                    $isActive = $model->status == \common\models\Symbol::STATUS_ACTIVE;
                    ?>
                    <span class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-sort-numeric-down me-2 text-primary"></i> Sort Order</span>
                            <span class="fw-bold"><?= $model->sort_order ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted"><i class="bi bi-hash me-2 text-primary"></i> Symbol ID</span>
                            <span class="text-muted">#<?= $model->id ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
