<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model pantera\rules\models\RuleActionLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rules Actions Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-actions-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'action_id',
            'model_id',
            'user_id',
            'status',
            'message:ntext',
            'created_at',
        ],
    ]) ?>

</div>
