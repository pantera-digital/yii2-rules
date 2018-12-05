<?php

use pantera\rules\models\Rule;
use yii\grid\GridView;
use yii\helpers\Html;
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
            'class',
            'event',
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (Rule $model) {
                    return Html::tag('span', $model->getStatusName()[$model->status], [
                        'class' => 'label label-' . ($model->status ? 'success' : 'danger')
                    ]);
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
