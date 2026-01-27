<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FooterBlock $model */
/** @var common\models\Language[] $languages */

$this->title = 'Update Footer Block #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Footer Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Block #' . $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="footer-block-update">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>