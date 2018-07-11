<?php

use pantera\rules\models\RuleActionLog;
use pantera\grid\widgets\dateRangePicker\DateRangePicker;
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
            'primary_key',
            'user_id',
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
                            $(this).val(picker.startDate.format("MM/DD/YYYY") + " - " + picker.endDate.format("MM/DD/YYYY")).trigger("change");
                        }'),
                        'cancel.daterangepicker' => new JsExpression('function(ev, picker){
                            $(this).val("").trigger("change");
                        }'),
                    ],
                ]),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (RuleActionLog $model) {
                    $class = $model->status ? 'success' : 'danger';
                    return '<span class="label label-' . $class . '">' . $model->getStatusName()[$model->status] . '</span>';
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
