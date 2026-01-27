<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FooterBlock $model */
/** @var common\models\Language[] $languages */

$this->title = 'Create Footer Block';
$this->params['breadcrumbs'][] = ['label' => 'Footer Blocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="footer-block-create">
    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages,
    ]) ?>
</div>