<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Menu;

/** @var yii\web\View $this */
/** @var common\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'status')->dropDownList([
        Menu::STATUS_ACTIVE => 'Active',
        Menu::STATUS_INACTIVE => 'Inactive',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>