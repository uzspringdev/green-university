<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Application $model */

$this->title = 'Update Status: ' . $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Status';
?>
<div class="application-update-status">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="application-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="alert alert-info">
            <strong>Applicant:</strong>
            <?= Html::encode($model->getFullName()) ?><br>
            <strong>Email:</strong>
            <?= Html::encode($model->email) ?><br>
            <strong>Phone:</strong>
            <?= Html::encode($model->phone) ?><br>
            <strong>Program:</strong>
            <?= Html::encode($model->program) ?>
        </div>

        <?= $form->field($model, 'status')->dropDownList(\common\models\Application::getStatusOptions()) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancel', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>