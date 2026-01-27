<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Portal Authentication';
?>
<div class="site-login-modern d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="login-card-modern p-5 rounded-4 shadow-lg bg-white border-0" style="max-width: 450px; width: 100%;">
        <div class="text-center mb-5">
            <?= Html::img('@web/images/logo.svg', ['alt' => 'Green University', 'style' => 'height:70px;', 'class' => 'mb-4']) ?>
            <h2 class="fw-bold text-primary h4 mb-2"><?= Html::encode($this->title) ?></h2>
            <p class="text-muted small">Administration & Admission Management</p>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'mt-4'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'small text-muted fw-bold uppercase'],
                'inputOptions' => ['class' => 'form-control rounded-pill px-4 py-3 border-light bg-light shadow-none'],
                'errorOptions' => ['class' => 'invalid-feedback ms-3'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Administrative Username']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '••••••••']) ?>

        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <?= $form->field($model, 'rememberMe', [
                'template' => "<div class=\"form-check custom-check\">\n{input}\n{label}\n{error}\n</div>",
                'labelOptions' => ['class' => 'form-check-label small text-muted cursor-pointer'],
            ])->checkbox(['class' => 'form-check-input shadow-none'], false) ?>
        </div>

        <div class="form-group mb-0">
            <?= Html::submitButton('Authorize Access <i class="bi bi-shield-lock ms-2"></i>', [
                'class' => 'btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm transition-all login-btn',
                'name' => 'login-button'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="text-center mt-5">
            <p class="smallest text-muted mb-0">&copy; <?= date('Y') ?> Green University of Uzbekistan</p>
            <div class="mt-2">
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 smallest">SECURE
                    ENVIRONMENT</span>
            </div>
        </div>
    </div>
</div>

<style>
    .site-login-modern {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .login-card-modern {
        transition: transform 0.3s ease;
    }

    .login-card-modern:hover {
        transform: translateY(-5px);
    }

    .form-control:focus {
        background: #fff !important;
        border-color: var(--admin-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(27, 67, 50, 0.1) !important;
    }

    .login-btn:hover {
        filter: brightness(1.1);
        transform: scale(1.02);
    }

    .uppercase {
        letter-spacing: 0.5px;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>