<?php

use pantera\rules\admin\Module;
use pantera\rules\models\RuleAction;
use himiklab\sortablegrid\SortableGridView;
use kartik\depdrop\DepDrop;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model pantera\rules\models\Rule */
/* @var $form yii\widgets\ActiveForm */
/* @var $module Module */
/* @var $dataProvider ActiveDataProvider */
$module = Yii::$app->controller->module;
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php $form = ActiveForm::begin([
            'validateOnBlur' => false,
            'validateOnChange' => false,
        ]); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'class')->dropDownList($module->classesList, [
            'prompt' => '---',
            'id' => 'model',
        ]) ?>

        <?= $form->field($model, 'event')->widget(DepDrop::classname(), [
            'options' => [
                'id' => 'event',
                'placeholder' => 'Select...',
            ],
            'data' => $module->getEventsOfClass($model->class),
            'pluginOptions' => [
                'depends' => ['model'],
                'url' => Url::to(['get-events'])
            ],
        ]); ?>

        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'status')->checkbox() ?>

        <?php if ($model->isNewRecord === false): ?>
            <h3>Actions</h3>
            <?php Pjax::begin([
                'id' => 'rules-actions-pjax-container',
            ]); ?>
            <?= SortableGridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'header' => '',
                        'format' => 'raw',
                        'value' => function (RuleAction $model) {
                            return Html::tag('span', '', [
                                'class' => 'glyphicon glyphicon-sort',
                            ]);
                        },
                        'options' => [
                            'style' => 'width: 32px;'
                        ],
                    ],
                    'name',
                    'created_at',
                    'updated_at',
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function (RuleAction $model) {
                            $class = $model->status ? 'success' : 'danger';
                            return '<span class="label label-' . $class . '">' . $model->getStatusName()[$model->status] . '</span>';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, RuleAction $model) {
                                return Html::a(Html::tag('span', '', [
                                    'class' => 'glyphicon glyphicon-pencil',
                                ]), ['update-action', 'id' => $model->id], [
                                    'data' => [
                                        'target' => '#rules-actions-modal',
                                        'toggle' => 'modal',
                                    ],
                                ]);
                            },
                            'delete' => function ($url, RuleAction $model) {
                                return Html::a(Html::tag('span', '', [
                                    'class' => 'glyphicon glyphicon-trash',
                                ]), ['delete-action', 'id' => $model->id], [
                                    'class' => 'delete-action',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

            <?= Html::a('Add action', ['create-action', 'id' => $model->id], [
            'class' => 'btn btn-default',
            'data' => [
                'target' => '#rules-actions-modal',
                'toggle' => 'modal',
            ],
        ]) ?>
            <br>
            <br>
        <?php endif; ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="modal" id="rules-actions-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>
