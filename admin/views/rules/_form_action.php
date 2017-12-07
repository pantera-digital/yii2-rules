<?php

use pantera\rules\admin\Module;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model pantera\rules\models\RuleAction */
/* @var $form yii\widgets\ActiveForm */
/* @var $module Module */
$module = Yii::$app->controller->module;
$this->title = $model->isNewRecord ? 'Add action' : 'Update action';
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><?= $this->title ?></h4>
</div>
<div class="modal-body">
    <?php $form = ActiveForm::begin([
        'id' => 'rules-actions-form',
        'validateOnBlur' => false,
        'validateOnChange' => false,
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div id="editor-container" class="form-group">
        <div id="editor"></div>
    </div>

    <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= Html::activeHiddenInput($model, 'php_code') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
