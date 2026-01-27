<?php

/** @var yii\web\View $this */
/** @var common\models\Application[] $applications */
/** @var common\models\ChatMessage[] $messages */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\User;
use common\models\Application;

$this->title = Yii::t('app', 'Student Dashboard');
/** @var User $identity */
$identity = Yii::$app->user->identity;
$userId = Yii::$app->user->id;

// Stats
$appCount = count($applications);
?>

<div class="dashboard-wrapper">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7 mb-4 mb-lg-0 animate-fade-up">
                    <span
                        class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25 rounded-pill px-3 py-2 mb-3 backdrop-blur">
                        <i class="bi bi-stars me-1 text-warning"></i> Welcome Back
                    </span>
                    <h1 class="display-4 fw-bold text-white mb-2 tracking-tight">
                        Hello, <?= Html::encode($identity->first_name) ?>!
                    </h1>
                    <p class="lead text-white text-opacity-90 mb-0 fw-light">
                        Here's what's happening with your applications today.
                    </p>
                </div>
                <div class="col-lg-5 animate-fade-up" style="animation-delay: 0.1s;">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="h3 fw-bold mb-0 text-dark"><?= $appCount ?></div>
                                    <div class="small text-muted">Applications</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="h3 fw-bold mb-0 text-dark"><?= count($messages) ?></div>
                                    <div class="small text-muted">Messages</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="hero-shape">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <div class="container main-content position-relative" style="margin-top: -60px; z-index: 10;">
        <div class="row g-4">

            <!-- Applications Section -->
            <div class="col-lg-7 animate-fade-up" style="animation-delay: 0.2s;">
                <div class="section-header d-flex align-items-center justify-content-between mb-4 px-2">
                    <h5 class="fw-bold text-white mb-0">My Applications</h5>
                    <a href="<?= Url::to(['application/index']) ?>"
                        class="btn btn-light btn-sm rounded-pill px-3 shadow-sm hover-scale text-primary fw-bold">
                        <i class="bi bi-plus-lg me-1"></i> New Application
                    </a>
                </div>

                <?php if (empty($applications)): ?>
                    <div class="empty-state card border-0 shadow-sm rounded-4 text-center py-5">
                        <div class="card-body">
                            <div class="empty-icon mb-3">
                                <i class="bi bi-folder2-open text-muted text-opacity-25" style="font-size: 4rem;"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Applications Found</h6>
                            <p class="text-muted small mb-4">You haven't applied to any programs yet.</p>
                            <a href="<?= Url::to(['application/index']) ?>"
                                class="btn btn-outline-primary rounded-pill px-4 btn-sm">
                                Browse Programs
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="application-list d-flex flex-column gap-3">
                        <?php foreach ($applications as $app): ?>
                            <div class="app-card card border-0 shadow-sm rounded-4 overflow-hidden hover-lift p-3">
                                <div class="d-flex align-items-center">
                                    <div class="program-icon rounded-3 bg-light text-primary d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="bi bi-mortarboard fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <h6 class="fw-bold text-dark mb-1 text-truncate"><?= Html::encode($app->program) ?></h6>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="text-muted small">
                                                <i class="bi bi-calendar3 me-1"></i> <?= date('M d, Y', $app->created_at) ?>
                                            </span>
                                            <span class="text-muted small font-monospace">
                                                #<?= $app->id ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php
                                    $statusConfig = [
                                        Application::STATUS_NEW => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'bi-hourglass-split', 'label' => 'Pending'],
                                        Application::STATUS_PROCESSING => ['class' => 'bg-info bg-opacity-10 text-info', 'icon' => 'bi-eye', 'label' => 'Processing'],
                                        Application::STATUS_APPROVED => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'bi-check-circle', 'label' => 'Approved'],
                                        Application::STATUS_REJECTED => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'bi-x-circle', 'label' => 'Rejected'],
                                    ];

                                    // Default fallback
                                    $statusData = $statusConfig[$app->status] ?? ['class' => 'bg-secondary bg-opacity-10 text-secondary', 'icon' => 'bi-question-circle', 'label' => $app->getStatusLabel()];
                                    ?>
                                    <div class="text-end ms-3">
                                        <span class="badge rounded-pill py-2 px-3 <?= $statusData['class'] ?>">
                                            <i class="bi <?= $statusData['icon'] ?> me-1"></i> <?= $app->getStatusLabel() ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Chat Section -->
            <div class="col-lg-5 animate-fade-up" style="animation-delay: 0.3s;">
                <div class="section-header d-flex align-items-center justify-content-between mb-4 px-2">
                    <h5 class="fw-bold text-white mb-0">Live Support</h5>
                    <span
                        class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25 rounded-pill px-3 py-2 backdrop-blur">
                        <i class="bi bi-dot fs-5 align-middle"></i> Online
                    </span>
                </div>

                <div class="chat-widget card border-0 shadow-lg rounded-4 overflow-hidden bg-white d-flex flex-column">
                    <!-- Chat Header -->
                    <div class="p-3 border-bottom bg-white d-flex align-items-center">
                        <div class="avatar-group position-relative me-3">
                            <div class="avatar rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 42px; height: 42px;">
                                <i class="bi bi-headset"></i>
                            </div>
                            <span
                                class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                                style="width: 12px; height: 12px;"></span>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Admission Office</h6>
                            <span class="text-muted small" style="font-size: 0.75rem;">Replies instantly</span>
                        </div>
                    </div>

                    <!-- Chat Body -->
                    <div class="chat-body p-3 bg-light flex-grow-1" id="chat-box">
                        <div class="text-center mb-4 mt-2">
                            <span
                                class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1 fw-normal text-uppercase"
                                style="font-size: 0.65rem; letter-spacing: 0.5px;">Today</span>
                        </div>

                        <!-- System Welcome -->
                        <div class="chat-message system mb-3 d-flex">
                            <div class="avatar rounded-circle bg-white text-primary border d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                style="width: 32px; height: 32px; font-size: 0.8rem;">AO</div>
                            <div class="message-content bg-white border shadow-sm p-3 rounded-4 rounded-top-left-0">
                                <p class="mb-0 text-dark small">Hello
                                    <strong><?= Html::encode($identity->first_name) ?></strong>! 👋<br>How can we assist
                                    you with your application today?
                                </p>
                                <div class="text-muted text-end mt-1" style="font-size: 0.65rem;">System</div>
                            </div>
                        </div>

                        <?php foreach ($messages as $msg): ?>
                            <?php $isMine = $msg->sender_id == $userId; ?>
                            <div class="chat-message mb-3 d-flex <?= $isMine ? 'justify-content-end me' : 'system' ?>">
                                <?php if (!$isMine): ?>
                                    <div class="avatar rounded-circle bg-white text-primary border d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                        style="width: 32px; height: 32px; font-size: 0.8rem;">AO</div>
                                <?php endif; ?>

                                <div class="message-content p-3 shadow-sm <?= $isMine ? 'bg-primary text-white rounded-4 rounded-bottom-right-0' : 'bg-white text-dark border rounded-4 rounded-top-left-0' ?>"
                                    style="max-width: 85%;">
                                    <div class="mb-1 small"><?= Html::encode($msg->message) ?></div>
                                    <div class="<?= $isMine ? 'text-white-50' : 'text-muted' ?> text-end"
                                        style="font-size: 0.65rem;">
                                        <?= date('H:i', $msg->created_at) ?>
                                        <?= $isMine ? '<i class="bi bi-check2 ms-1"></i>' : '' ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Chat Footer -->
                    <div class="p-3 bg-white border-top">
                        <form id="chat-form" class="position-relative">
                            <div class="input-group">
                                <input type="text" id="message-input"
                                    class="form-control bg-light border-0 rounded-pill py-2 ps-3"
                                    placeholder="Type a message..." autocomplete="off" style="padding-right: 50px;">
                                <button type="submit"
                                    class="btn btn-primary rounded-circle position-absolute end-0 top-50 translate-middle-y me-1 shadow-sm d-flex align-items-center justify-content-center hover-scale"
                                    style="width: 38px; height: 38px; z-index: 5;">
                                    <i class="bi bi-send-fill" style="font-size: 0.9rem;"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    /* Base */
    .dashboard-wrapper {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* Animations */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-green, #1B4332) 0%, var(--secondary-green, #2D6A4F) 100%);
        padding-bottom: 140px;
        position: relative;
        overflow: hidden;
    }

    .hero-shape {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .hero-shape svg {
        position: relative;
        display: block;
        width: calc(150% + 1.3px);
        height: 60px;
    }

    .hero-shape .shape-fill {
        fill: #f8f9fa;
    }

    /* Stats Cards */
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Application Cards */
    .app-card {
        background: #fff;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid rgba(0, 0, 0, 0.03) !important;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    .btn-primary {
        background-color: #10b981;
        border-color: #10b981;
    }

    .btn-primary:hover {
        background-color: #059669;
        border-color: #059669;
    }

    .text-primary {
        color: #10b981 !important;
    }

    .bg-primary {
        background-color: #10b981 !important;
    }

    .btn-outline-primary {
        color: #10b981;
        border-color: #10b981;
    }

    .btn-outline-primary:hover {
        background-color: #10b981;
        color: #fff;
    }

    /* Chat Widget */
    .chat-widget {
        height: 70vh;
        max-height: 750px;
        min-height: 500px;
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
    }

    .chat-body {
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
    }

    .chat-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-body::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 20px;
    }

    .message-content {
        position: relative;
        word-wrap: break-word;
    }

    .rounded-bottom-right-0 {
        border-bottom-right-radius: 0 !important;
    }

    .rounded-top-left-0 {
        border-top-left-radius: 0 !important;
    }

    .hover-scale {
        transition: transform 0.2s;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Utilities */
    .backdrop-blur {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .tracking-tight {
        letter-spacing: -0.5px;
    }
</style>

<?php
$sendUrl = Url::to(['dashboard/send-message']);
$getUrl = Url::to(['dashboard/get-messages']);
$lastId = !empty($messages) ? end($messages)->id : 0;

$script = <<<JS
    let lastMessageId = {$lastId};
    const chatBox = document.getElementById('chat-box');
    
    // Auto scroll to bottom
    const scrollToBottom = () => {
        chatBox.scrollTo({top: chatBox.scrollHeight, behavior: 'smooth'});
    }
    // Initial scroll (instant)
    chatBox.scrollTop = chatBox.scrollHeight;

    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        const input = $('#message-input');
        const text = input.val().trim();
        const btn = $(this).find('button');
        
        if (!text) return;
        
        // Disable button temporarily
        btn.prop('disabled', true);

        // Send message
        $.post('{$sendUrl}', {message: text}, function(response) {
            btn.prop('disabled', false);
            if (response.success) {
                const msg = {
                    id: response.message.id,
                    text: response.message.text,
                    time: response.message.time,
                    is_mine: true
                };
                appendMessage(msg);
                lastMessageId = response.message.id;
                input.val('');
                input.focus();
            } else {
                // Show error toast or alert using sleek UI if possible, fallback to alert
                alert(response.error || 'Error sending message');
            }
        }).fail(function() {
            btn.prop('disabled', false);
            alert('Network error. Please try again.');
        });
    });

    function appendMessage(msg) {
        const isMine = msg.is_mine;
        // Template literal for message
        const html = `
            <div class="chat-message mb-3 d-flex \${isMine ? 'justify-content-end me animate-fade-up' : 'system animate-fade-up'}">
                \${!isMine ? '<div class="avatar rounded-circle bg-white text-primary border d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.8rem;">AO</div>' : ''}
                
                <div class="message-content p-3 shadow-sm \${isMine ? 'bg-primary text-white rounded-4 rounded-bottom-right-0' : 'bg-white text-dark border rounded-4 rounded-top-left-0'}" style="max-width: 85%;">
                    <div class="mb-1 small">\${msg.text}</div>
                    <div class="\${isMine ? 'text-white-50' : 'text-muted'} text-end" style="font-size: 0.65rem;">
                        \${msg.time} \${isMine ? '<i class="bi bi-check2 ms-1"></i>' : ''}
                    </div>
                </div>
            </div>
        `;
        $(chatBox).append(html);
        scrollToBottom();
    }

    // Polling
    setInterval(function() {
        $.get('{$getUrl}', {lastId: lastMessageId}, function(response) {
            if (response.success && response.messages.length > 0) {
                let hasNew = false;
                response.messages.forEach(function(msg) {
                     // Dedup client side just in case
                    if(msg.id > lastMessageId) {
                        appendMessage(msg);
                        lastMessageId = msg.id;
                        hasNew = true;
                    }
                });
                if(hasNew) scrollToBottom();
            }
        });
    }, 4000); 
JS;
$this->registerJs($script);
?>