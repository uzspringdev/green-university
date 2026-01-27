<?php
use yii\helpers\Html;

$this->title = 'Update Page: ' . $model->slug;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-update">
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    <?= $this->render('_form', ['model' => $model, 'languages' => $languages]) ?>
</div>