<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Administrative Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">
    <!-- Profile Hero Section -->
    <div class="profile-hero mb-4 rounded-4 overflow-hidden position-relative"
        style="background: linear-gradient(135deg, #081C15 0%, #1B4332 100%); padding: 60px 40px;">
        <div class="row align-items-center">
            <div class="col-md-auto text-center text-md-start mb-4 mb-md-0">
                <div class="profile-avatar-large shadow-lg">
                    <?= strtoupper(substr($model->username, 0, 2)) ?>
                </div>
            </div>
            <div class="col-md ps-md-4 text-center text-md-start text-white">
                <h1 class="display-6 fw-bold mb-1">
                    <?= Html::encode($model->username) ?>
                </h1>
                <p class="opacity-75 mb-3 fs-5">Administrative Management Authority</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                    <span
                        class="badge bg-white bg-opacity-10 text-white rounded-pill px-3 py-2 border border-white border-opacity-10">
                        <i class="bi bi-envelope me-2"></i>
                        <?= Html::encode($model->email) ?>
                    </span>
                    <span
                        class="badge bg-success bg-opacity-25 text-white rounded-pill px-3 py-2 border border-success border-opacity-25">
                        <i class="bi bi-shield-check me-2"></i> Authorized Admin
                    </span>
                </div>
            </div>
            <div class="col-md-auto text-center text-md-end mt-4 mt-md-0">
                <?= Html::a('<i class="bi bi-pencil-square me-2"></i> Update Credentials', ['update'], ['class' => 'btn btn-white-glass rounded-pill px-4 py-2']) ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Account Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Identity & Account Details</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label class="smallest text-muted fw-bold uppercase mb-2">Login Username</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark">
                                <?= Html::encode($model->username) ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="smallest text-muted fw-bold uppercase mb-2">Registered Email</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark">
                                <?= Html::encode($model->email) ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="smallest text-muted fw-bold uppercase mb-2">Account Status</label>
                            <div class="p-3 bg-light rounded-3">
                                <span class="badge rounded-pill bg-success px-3 py-1">ACTIVE</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="smallest text-muted fw-bold uppercase mb-2">Last System Audit</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark">
                                <?= Yii::$app->formatter->asDatetime($model->updated_at) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security & Access -->
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-light text-primary rounded-3 p-3">
                            <i class="bi bi-shield-lock-fill fs-2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Security Standards</h5>
                            <p class="text-muted small mb-0">Your account is secured with advanced hashing and CSRF
                                protection.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Platform Statistics</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Account Age</span>
                            <span class="fw-bold text-dark">
                                <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
                            </span>
                        </div>
                        <div class="progress rounded-pill" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="p-3 bg-primary bg-opacity-10 rounded-4 text-primary">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-info-circle-fill fs-3"></i>
                            <div class="smallest fw-bold">Note: Profile updates will be logged in the system activity
                                audit.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-clock-history fs-1 text-muted opacity-50"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1">Session Integrity</h6>
                <p class="smallest text-muted mb-0">Active connection from IP:
                    <?= Yii::$app->request->userIP ?>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        background: var(--admin-primary-light);
        color: var(--admin-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        border-radius: 30px;
        border: 4px solid rgba(255, 255, 255, 0.2);
    }

    .btn-white-glass {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        transition: all 0.3s;
    }

    .btn-white-glass:hover {
        background: #fff;
        color: var(--admin-primary);
    }

    .uppercase {
        letter-spacing: 0.5px;
    }
</style>