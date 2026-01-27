<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Application $model */

$this->title = 'Application: ' . $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-view mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark"><?= Html::encode($this->title) ?></h1>
            <p class="text-muted mb-0">Admission Application Review</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil-square me-1"></i> Update Status', ['update-status', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4 shadow-sm']) ?>
            <?= Html::a('<i class="bi bi-trash me-1"></i> Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger rounded-pill px-4 shadow-sm',
                'data' => [
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Applicant Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Full Name</div>
                        <div class="col-sm-9 fw-bold"><?= Html::encode($model->getFullName()) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Email</div>
                        <div class="col-sm-9"><a href="mailto:<?= Html::encode($model->email) ?>"
                                class="text-primary text-decoration-none"><?= Html::encode($model->email) ?></a></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Phone</div>
                        <div class="col-sm-9 fw-medium"><?= Html::encode($model->phone) ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Attached File</div>
                        <div class="col-sm-9">
                            <?php if ($model->file): ?>
                                <a href="http://localhost:8080/<?= $model->file ?>" target="_blank"
                                    class="text-decoration-none fw-bold text-primary">
                                    <i class="bi bi-paperclip me-1"></i> Download Document
                                </a>
                            <?php else: ?>
                                <span class="text-muted small fst-italic">No file attached</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr class="text-light">
                    <div class="row mb-3">
                        <div class="col-sm-3 text-muted">Applied Program</div>
                        <div class="col-sm-9"><span
                                class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><?= Html::encode($model->program) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Message / Cover Letter</h5>
                </div>
                <div class="card-body p-4">
                    <div class="bg-light p-4 rounded text-muted line-height-lg content-text">
                        <?= $model->message ? nl2br(Html::encode($model->message)) : '<span class="fst-italic opacity-50">No message provided.</span>' ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div
                    class="card-header bg-transparent py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark small text-uppercase">Application Info</h5>
                    <?php
                    $status = $model->status;
                    $class = 'bg-secondary';
                    if ($status == \common\models\Application::STATUS_NEW)
                        $class = 'bg-warning text-dark';
                    if ($status == \common\models\Application::STATUS_PROCESSING)
                        $class = 'bg-info text-white';
                    if ($status == \common\models\Application::STATUS_APPROVED)
                        $class = 'bg-success text-white';
                    ?>
                    <span class="badge rounded-pill px-3 py-2 <?= $class ?>"><?= $model->getStatusLabel() ?></span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-hash me-2 text-primary"></i> Application ID</span>
                            <span class="fw-bold">#<?= $model->id ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <span class="text-muted"><i class="bi bi-calendar-check me-2 text-primary"></i> Submitted
                                At</span>
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
                <div class="card-body p-4 text-center">
                    <i class="bi bi-info-circle fs-3 text-primary opacity-50 mb-3 d-block"></i>
                    <p class="small text-muted mb-0">Use the 'Update Status' button above to move this application
                        through the admission workflow.</p>
                </div>
            </div>
        </div>
    </div>
</div>