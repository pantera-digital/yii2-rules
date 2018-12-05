<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model pantera\rules\models\Rule */

$this->title = 'Create Rules';
$this->params['breadcrumbs'][] = ['label' => 'Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
