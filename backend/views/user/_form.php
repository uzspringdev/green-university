<?php

use common\models\User;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        'id' => 'staff-form',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'smallest text-muted fw-bold uppercase mb-2 d-block'],
            'inputOptions' => ['class' => 'form-control rounded-pill px-4 py-2 border-light bg-light shadow-none'],
            'errorOptions' => ['class' => 'invalid-feedback ms-3'],
        ],
    ]); ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Identity & Credentials</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Enter login username']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Enter administrative email']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->isNewRecord ? 'Set account password' : 'Leave blank to keep current password']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'role')->dropDownList([
                                User::ROLE_ADMIN => 'Standard Administrative Staff',
                                User::ROLE_SUPER_ADMIN => 'System Super Administrator',
                            ], ['class' => 'form-select rounded-pill px-4 py-2 border-light bg-light shadow-none']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Module Authority Matrix</h5>
                    <p class="text-muted smallest mb-0">Grant access to specific administrative domains</p>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="permission-grid py-2">
                        <?= $form->field($model, 'permissions')->checkboxList(User::getAllPermissions(), [
                            'item' => function ($index, $label, $name, $checked, $value) {
                            $checkedAttr = $checked ? 'checked' : '';
                            return '<div class="col-md-6 mb-3">
                                    <div class="permission-card p-3 rounded-4 border-2 transition ' . ($checked ? 'border-primary bg-primary-light' : 'border-light bg-white') . '">
                                        <div class="form-check d-flex align-items-center gap-3">
                                            <input class="form-check-input flex-shrink-0" type="checkbox" name="' . $name . '" value="' . $value . '" id="perm-' . $value . '" ' . $checkedAttr . '>
                                            <label class="form-check-label flex-grow-1 fw-bold text-dark cursor-pointer" for="perm-' . $value . '">
                                                ' . $label . '
                                                <div class="smallest text-muted fw-normal">Authorize access to the ' . strtolower(explode(' ', $label)[0]) . ' subsystem</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>';
                        },
                            'class' => 'row g-3'
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white p-4">
                <i class="bi bi-shield-lock-fill fs-1 mb-3 opacity-50"></i>
                <h6 class="fw-bold">Security Compliance</h6>
                <p class="smallest mb-4">Adhere to internal security policies when creating staff accounts. Use complex
                    passwords and verify identity.</p>
                <?= Html::submitButton($model->isNewRecord ? '<i class="bi bi-person-plus me-2"></i> Deploy Staff Account' : '<i class="bi bi-check2-all me-2"></i> Update Authority', ['class' => 'btn btn-white-glass w-100 rounded-pill py-3 fw-bold']) ?>
                <?= Html::a('Discard Changes', ['index'], ['class' => 'btn btn-link text-white text-decoration-none w-100 mt-2 smallest']) ?>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-2">Authority Note</h6>
                <p class="smallest text-muted mb-0">Super Administrators automatically possess all permissions. For
                    Standard Staff, use the matrix below to delegate tasks.</p>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
    .permission-card {
        border-style: solid;
        cursor: pointer;
    }

    .permission-card:hover {
        border-color: var(--admin-primary);
    }

    .transition {
        transition: all 0.2s ease;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0;
    }

    .form-check-input:checked {
        background-color: var(--admin-primary);
        border-color: var(--admin-primary);
    }
</style>

<script>
    // Toggle card styling based on checkbox state
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const card = this.closest('.permission-card');
                if (this.checked) {
                    card.classList.add('border-primary', 'bg-primary-light');
                    card.classList.remove('border-light', 'bg-white');
                } else {
                    card.classList.remove('border-primary', 'bg-primary-light');
                    card.classList.add('border-light', 'bg-white');
                }
            });
        });
    });
</script>