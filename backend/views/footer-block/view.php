<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FooterBlock $model */

$this->title = 'Footer Block #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Footer Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="footer-block-view mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Review content and configuration of this footer block</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil me-1"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this block?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom text-start">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Content Translations</h5>
                </div>
                <div class="card-body p-4 text-start">
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
                                <div class="p-3 bg-light rounded-4 font-monospace small overflow-auto"
                                    style="max-height: 300px;">
                                    <?= nl2br(Html::encode($translation->content)) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden text-start">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Information</h5>
                    <?php
                    $isActive = $model->status == \common\models\FooterBlock::STATUS_ACTIVE;
                    ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-columns me-2 text-primary"></i>
                                Column Position</span>
                            <span class="fw-bold text-primary">
                                <?php
                                $columns = [
                                    1 => 'Column 1 (Left)',
                                    2 => 'Column 2 (Center)',
                                    3 => 'Column 3 (Right)',
                                    4 => 'Column 4 (Far Right)',
                                ];
                                echo $columns[$model->column_position] ?? 'Unknown';
                                ?>
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-sort-numeric-down me-2 text-primary"></i> Sort
                                Order</span>
                            <span class="fw-bold">
                                <?= $model->sort_order ?>
                            </span>
                        </div>
                        <div
                            class="list-group-item d-flex justify-content-between align-items-center py-3 border-bottom-0">
                            <span class="text-muted"><i class="bi bi-hash me-2 text-primary"></i> Block ID</span>
                            <span class="text-muted">#
                                <?= $model->id ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>