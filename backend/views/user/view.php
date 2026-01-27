<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Staff Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">Staff Dossier:
                <?= Html::encode($this->title) ?>
            </h1>
            <p class="text-muted smallest mb-0">Review administrative identity and assigned authority</p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('<i class="bi bi-pencil-square me-2"></i> Modify Authority', ['update', 'id' => $model->id], ['class' => 'btn btn-primary rounded-pill px-4']) ?>
            <?php if ($model->id != Yii::$app->user->id): ?>
                <?= Html::a('<i class="bi bi-trash-fill me-2"></i> Revoke Access', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger rounded-pill px-4',
                    'data' => [
                        'confirm' => 'Are you sure you want to permanently revoke this user\'s access?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">System Identity</h5>
                </div>
                <div class="card-body p-0 pb-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-hover mb-0 detail-view-modern'],
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4', 'style' => 'width: 250px;'],
                                'contentOptions' => ['class' => 'fw-medium text-dark'],
                            ],
                            [
                                'attribute' => 'username',
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                                'contentOptions' => ['class' => 'fw-bold text-dark'],
                            ],
                            [
                                'attribute' => 'email',
                                'format' => 'email',
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                                'contentOptions' => ['class' => 'fw-medium text-dark'],
                            ],
                            [
                                'attribute' => 'role',
                                'format' => 'raw',
                                'value' => function ($model) {
                                        $class = $model->role == User::ROLE_SUPER_ADMIN ? 'bg-danger text-white' : 'bg-primary text-white';
                                        return '<span class="badge rounded-pill ' . $class . ' px-3 py-1">' . $model->getRoleLabel() . '</span>';
                                    },
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => function ($model) {
                                        $class = $model->status == User::STATUS_ACTIVE ? 'success' : 'warning';
                                        $label = $model->status == User::STATUS_ACTIVE ? 'Active' : 'Inactive';
                                        return '<span class="status-badge-modern ' . $class . '"><span class="pulse-dot"></span>' . $label . '</span>';
                                    },
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                                'contentOptions' => ['class' => 'text-muted'],
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'datetime',
                                'labelOptions' => ['class' => 'text-muted smallest fw-bold uppercase ps-4'],
                                'contentOptions' => ['class' => 'text-muted'],
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Authorized Modules</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <?php if ($model->isSuperAdmin()): ?>
                        <div class="alert alert-success border-0 rounded-4 p-4">
                            <div class="d-flex gap-3 align-items-center">
                                <i class="bi bi-shield-fill-check fs-1"></i>
                                <div>
                                    <div class="fw-bold fs-5">Universal Authority</div>
                                    <div class="smallest opacity-75">This account has absolute control over all system
                                        parameters and data.</div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush border-0">
                            <?php
                            $perms = $model->getPermissionsList();
                            $allPerms = User::getAllPermissions();
                            if (empty($perms)): ?>
                                <div class="text-center py-4 text-muted italics">No specific authority assigned.</div>
                            <?php else: ?>
                                <?php foreach ($perms as $perm): ?>
                                    <div class="list-group-item px-0 border-0 bg-transparent py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-primary-light text-primary rounded-3 p-2">
                                                <i class="bi bi-check2-circle fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark smallest uppercase">
                                                    <?= $allPerms[$perm] ?? $perm ?>
                                                </div>
                                                <div class="smallest text-muted">Authorized subsystem access</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-light rounded-4 p-4 text-center">
                <i class="bi bi-clock-history fs-3 text-muted opacity-50 mb-2 d-block"></i>
                <div class="smallest text-muted">Security Policy: Administrative actions are logged for audit purposes.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .detail-view-modern th {
        border-top: 1px solid #f8f9fa !important;
    }

    .detail-view-modern td {
        border-top: 1px solid #f8f9fa !important;
    }

    .bg-primary-light {
        background-color: rgba(27, 67, 50, 0.1);
    }

    .uppercase {
        letter-spacing: 0.05em;
    }

    .italics {
        font-style: italic;
    }
</style>