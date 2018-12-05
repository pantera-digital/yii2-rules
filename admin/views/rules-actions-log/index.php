<?php

use pantera\grid\widgets\dateRangePicker\DateRangePicker;
use pantera\rules\models\RuleActionLog;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel pantera\rules\models\RuleActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rules Actions Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-actions-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'action_id',
            [
                'attribute' => 'created_at',
                'value' => function (RuleActionLog $model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'pluginOptions' => [
                        'autoUpdateInput' => false,
                    ],
                    'pluginEvents' => [
                        'apply.daterangepicker' => new JsExpression('function(ev, picker){
                            const start = picker.startDate.format("MM/DD/YYYY");
                            const stop = picker.endDate.format("MM/DD/YYYY")
                            $(this).val(start + " - " + stop).trigger("change");
                        }'),
                        'cancel.daterangepicker' => new JsExpression('function(ev, picker){
                            $(this).val("").trigger("change");
                        }'),
                    ],
                    'options' => [
                        'autocomplete' => 'off',
                    ],
                ]),
            ],
            'primary_key',
            'user_id',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (RuleActionLog $model) {
                    return Html::tag('span', $model->getStatusName()[$model->status], [
                        'class' => 'label label-' . ($model->status ? 'success' : 'danger')
                    ]);
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusName(), [
                    'prompt' => '---',
                    'class' => 'form-control',
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
