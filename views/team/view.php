<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 01.12.2018
 * Time: 13:23
 */
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
?>

<h2> <?=$model->title?></h2>

<h2>Участники: </h2>
<?php if(count($members)): ?>
    <?= \app\widgets\Members::widget(['members' => $members]) ?>
<?php else: ?>
    <?= 'Участников нет' ?>
<?php endif; ?>
<hr>
<h2>Задачи: </h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ($model) {
        if ($model->deadline_timestamp < time()) {
            return ['class' => 'danger'];
        } elseif ($model->end_timestamp) {
            return ['class' => 'success'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'title',
        'begin_timestamp:datetime',
        'deadline_timestamp:datetime',
        //'end_timestamp:datetime',
        //'admin_id',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn', 'template' => '{view}', 'controller' => 'task'],
    ],
]); ?>
