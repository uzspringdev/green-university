<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Update Profile Context';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profile-update">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 800px;">
        <div class="card-header bg-primary text-white py-4 px-4 border-0">
            <h5 class="fw-bold mb-0">Security & Credentials</h5>
            <p class="smallest opacity-75 mb-0">Modify your administrative access parameters</p>
        </div>
        <div class="card-body p-5">
            <?php $form = ActiveForm::begin([
                'id' => 'profile-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'small text-muted fw-bold uppercase mb-2'],
                    'inputOptions' => ['class' => 'form-control rounded-pill px-4 py-2 border-light bg-light shadow-none'],
                    'errorOptions' => ['class' => 'invalid-feedback ms-3'],
                ],
            ]); ?>

            <div class="row g-4">
                <div class="col-md-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="alert alert-info rounded-4 border-0 shadow-xs p-4 mt-4 mb-4">
                <div class="d-flex gap-3">
                    <i class="bi bi-info-circle-fill fs-3 text-primary"></i>
                    <div class="small">
                        <div class="fw-bold text-dark">Data Optimization</div>
                        Your username is fixed to maintain system integrity. You can update your contact email for
                        security notifications.
                    </div>
                </div>
            </div>

            <div class="form-group mb-0 mt-5 pt-4 border-top">
                <?= Html::submitButton('<i class="bi bi-check2-all me-2"></i> Save Profile Modifications', ['class' => 'btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-link link-secondary text-decoration-none px-4']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background: #fff !important;
        border-color: var(--admin-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(27, 67, 50, 0.1) !important;
    }

    .uppercase {
        letter-spacing: 0.5px;
    }
</style>