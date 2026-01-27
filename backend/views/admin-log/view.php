<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AdminLog $model */

$this->title = 'Log Details #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="admin-log-view mt-3 text-start">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted mb-0">Detailed breakdown of the administrative action</p>
        </div>
        <?= Html::a('<i class="bi bi-arrow-left me-1"></i> Back to Logs', ['index'], ['class' => 'btn btn-outline-secondary rounded-pill px-4']) ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Action Summary</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Performed By</label>
                            <div class="fw-bold fs-5 text-dark">
                                <?= $model->user ? $model->user->username : 'System' ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Action Type</label>
                            <div>
                                <?php
                                $badgeClass = 'bg-secondary';
                                if (stripos($model->action, 'create') !== false)
                                    $badgeClass = 'bg-success';
                                if (stripos($model->action, 'update') !== false)
                                    $badgeClass = 'bg-info';
                                if (stripos($model->action, 'delete') !== false)
                                    $badgeClass = 'bg-danger';
                                ?>
                                <span
                                    class="badge rounded-pill px-3 py-2 <?= $badgeClass ?> bg-opacity-10 text-<?= str_replace('bg-', '', $badgeClass) ?>">
                                    <?= strtoupper($model->action) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Timestamp</label>
                            <div class="text-dark">
                                <?= date('d F Y, H:i:s', $model->created_at) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-muted text-uppercase fw-bold mb-1 d-block">Target Entity</label>
                            <div class="font-monospace text-primary">
                                <?= $model->model ?> (ID:
                                <?= $model->model_id ?>)
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Log Description</h5>
                </div>
                <div class="card-body p-4">
                    <p class="mb-0 text-muted fs-6">
                        <?= $model->description ?: '<span class="fst-italic opacity-50">No additional details provided.</span>' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>