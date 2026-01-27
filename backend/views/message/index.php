<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Student Support Chat';
?>
<div class="message-index h-100">
    <div class="row g-0 h-100 shadow-sm rounded-3 overflow-hidden border bg-white" style="min-height: 75vh;">
        <!-- Sidebar -->
        <div class="col-md-4 col-lg-3 border-end h-100 d-flex flex-column">
            <div class="p-3 border-bottom bg-light">
                <h5 class="mb-0 fw-bold">Conversations</h5>
            </div>
            <div class="list-group list-group-flush overflow-auto flex-grow-1" id="chat-list">
                <?php if (empty($chats)): ?>
                    <div class="p-4 text-center text-muted small">No active conversations</div>
                <?php else: ?>
                    <?php foreach ($chats as $chat): ?>
                        <?php
                        $user = $chat['user'];
                        $lastMsg = $chat['last_message'];
                        $unread = $chat['unread_count'];
                        ?>
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0 border-bottom chat-item"
                            data-conversation-id="<?= $chat['conversation_id'] ?>" data-user-id="<?= $user->id ?>">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                <strong class="mb-1 text-truncate">
                                    <?= Html::encode($user->first_name . ' ' . $user->last_name) ?>
                                </strong>
                                <?= date('M d H:i', $lastMsg->created_at) ?>
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="text-muted small text-truncate" style="max-width: 150px;">
                                    <?= $lastMsg->sender_id == Yii::$app->user->id ? '<i class="bi bi-reply-fill"></i> ' : '' ?>
                                    <?= Html::encode($lastMsg->message) ?>
                                </div>
                                <?php if ($unread > 0): ?>
                                    <span class="badge bg-danger rounded-pill">
                                        <?= $unread ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 col-lg-9 h-100 d-flex flex-column bg-light">
            <!-- Header -->
            <div class="p-3 border-bottom bg-white d-flex align-items-center justify-content-between" id="chat-header"
                style="height: 65px;">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold" id="chat-title">Select a conversation</h5>
                </div>
            </div>

            <!-- Messages -->
            <div class="p-4 overflow-auto flex-grow-1" id="chat-box" style="scroll-behavior: smooth;">
                <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                    <div class="text-center">
                        <i class="bi bi-chat-dots fs-1 mb-3 opacity-25"></i>
                        <p>Select a student from the sidebar to start chatting</p>
                    </div>
                </div>
            </div>

            <!-- Input -->
            <div class="p-3 bg-white border-top">
                <form id="admin-chat-form" class="d-none">
                    <input type="hidden" id="current-conversation-id">
                    <div class="input-group">
                        <input type="text" id="admin-message-input" class="form-control border-0 bg-light"
                            placeholder="Type a reply..." autocomplete="off">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$viewUrl = Url::to(['message/view']);
$sendUrl = Url::to(['message/send']);

$script = <<<JS
    const viewUrl = '{$viewUrl}';
    const sendUrl = '{$sendUrl}';

    $('.chat-item').on('click', function(e) {
        e.preventDefault();
        $('.chat-item').removeClass('active bg-light');
        $(this).addClass('active bg-light');
        
        // Remove unread badge
        $(this).find('.badge').remove();

        const conversationId = $(this).data('conversation-id');
        const userId = $(this).data('user-id');
        const userName = $(this).find('strong').text();

        // Update header
        $('#chat-title').text(userName);
        $('#current-conversation-id').val(conversationId);
        $('#admin-chat-form').removeClass('d-none');
        $('#admin-message-input').val('').focus(); // Clear previous input

        // Load messages
        $('#chat-box').html('<div class="d-flex justify-content-center pt-5"><div class="spinner-border text-primary"></div></div>');
        
        // View Action now expects Conversation ID
        $.get(viewUrl, {id: conversationId}, function(data) {
            $('#chat-box').html(data);
            scrollToBottom();
        });
    });

    $('#admin-chat-form').on('submit', function(e) {
        e.preventDefault();
        const text = $('#admin-message-input').val().trim();
        const conversationId = $('#current-conversation-id').val();

        if (!text || !conversationId) return;

        $.post(sendUrl, {conversation_id: conversationId, message: text}, function(response) {
            if (response.success) {
                appendAdminMessage(response.message);
                $('#admin-message-input').val('');
            } else {
                alert('Error sending message: ' + (response.error || 'Unknown error'));
            }
        });
    });

    function appendAdminMessage(msg) {
        const html = `
            <div class="d-flex justify-content-end mb-3">
                <div class="p-3 shadow-sm bg-primary text-white rounded-bottom-0 rounded-start-4 rounded-top-4" style="max-width: 75%;">
                    <div class="mb-1">\${msg.text}</div>
                    <div class="text-white-50" style="font-size: 0.7rem; text-align: right;">\${msg.time}</div>
                </div>
            </div>
        `;
        $('#chat-box').append(html);
        scrollToBottom();
    }

    function scrollToBottom() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }
JS;
$this->registerJs($script);
?>