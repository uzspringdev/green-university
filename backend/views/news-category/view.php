<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\NewsCategory $model */

$this->title = $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'News Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-category-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Category Identifier & Metadata</p>
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
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Basic Information</h5>
                </div>
                <div class="card-body p-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'labelOptions' => ['class' => 'ps-4 text-muted small fw-normal'],
                                'contentOptions' => ['class' => 'fw-bold'],
                            ],
                            [
                                'attribute' => 'slug',
                                'labelOptions' => ['class' => 'ps-4 text-muted small fw-normal'],
                                'contentOptions' => ['class' => 'font-monospace'],
                            ],
                            [
                                'label' => 'Translations',
                                'format' => 'raw',
                                'labelOptions' => ['class' => 'ps-4 text-muted small fw-normal'],
                                'value' => function ($model) {
                                            $html = '<div class="d-flex flex-wrap gap-2">';
                                            foreach ($model->translations as $trans) {
                                                $html .= Html::tag('span', $trans->language->name . ': ' . $trans->name, ['class' => 'badge bg-light text-dark border']);
                                            }
                                            return $html . '</div>';
                                        }
                            ],
                        ],
                        'options' => ['class' => 'table table-hover align-middle mb-0'],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">System Info</h5>
                    <?php
                    $isActive = $model->status === \common\models\NewsCategory::STATUS_ACTIVE;
                    ?>
                    <span
                        class="badge rounded-pill px-3 py-2 <?= $isActive ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-dark' ?>">
                        <?= $isActive ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-calendar-plus me-2 text-primary"></i>
                                Created</span>
                            <span class="fw-medium"><?= date('d M Y, H:i', $model->created_at) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-clock-history me-2 text-primary"></i>
                                Updated</span>
                            <span class="fw-medium"><?= date('d M Y, H:i', $model->updated_at) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>