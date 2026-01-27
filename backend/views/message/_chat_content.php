<?php
use yii\helpers\Html;

/** @var common\models\ChatMessage[] $messages */
/** @var common\models\User $student */
?>

<?php foreach ($messages as $msg): ?>
    <?php $isMine = $msg->sender_id == Yii::$app->user->id; ?>
    <div class="d-flex mb-3 <?= $isMine ? 'justify-content-end' : '' ?>">
        <?php if (!$isMine): ?>
            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                style="width: 35px; height: 35px; font-size: 0.8rem;">
                <?= strtoupper(substr($student->username, 0, 1)) ?>
            </div>
        <?php endif; ?>

        <div class="p-3 shadow-sm <?= $isMine ? 'bg-primary text-white rounded-bottom-0 rounded-start-4 rounded-top-4' : 'bg-white text-dark rounded-bottom-0 rounded-end-4 rounded-top-4' ?>"
            style="max-width: 75%;">
            <div class="mb-1">
                <?= Html::encode($msg->message) ?>
            </div>
            <div class="<?= $isMine ? 'text-white-50' : 'text-muted' ?>" style="font-size: 0.7rem; text-align: right;">
                <?= date('H:i', $msg->created_at) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>