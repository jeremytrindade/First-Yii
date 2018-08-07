<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */   
/* @var $user app\models\user */
/* @var $form ActiveForm */
?>

<div class="user-register">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($user); ?>
        <?= $form->field($user, 'full_name'); ?>
        <?= $form->field($user, 'username'); ?>
        <?= $form->field($user, 'email'); ?>
        <?= $form->field($user, 'password')->passwordInput(); ?>
        <?= $form->field($user, 'password_repeat')->passwordInput(); ?>

        <div class="from-group">
            <?= Html::submitButton('Save', ['class'=>'btn btn-primary']); ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>