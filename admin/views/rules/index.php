<?php

use pantera\rules\models\Rule;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel pantera\rules\models\RuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-index">

    <h1>
        <div class="pull-right">
            <?= Html::a('Create new rule', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= Html::encode($this->title) ?>
    </h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped'
        ],
        'columns' => [
            'name',
            'model',
            'event',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    /* @var $model Rule */
                    $class = $model->status ? 'success' : 'danger';
                    return '<span class="label label-' . $class . '">' . $model->getStatusName()[$model->status] . '</span>';
                },
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusName(), [
                    'prompt' => '---',
                    'class' => 'form-control',
                ]),
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
