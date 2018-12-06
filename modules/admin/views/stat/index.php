<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 07.12.2018
 * Time: 0:19
 */

use yii\grid\GridView;

?>
<h2>Статистика по задачам</h2>
<h3>Все Задачи: </h3>
<?= GridView::widget([
    'dataProvider' => $dataProviderAllTasks,
    'filterModel' => $searchModelAllTasks,
    'rowOptions' => function ($model) {
        if ($model->deadline_timestamp < time()) {
            return ['class' => 'danger'];
        } elseif ($model->end_timestamp) {
            return ['class' => 'success'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'user.login',
        'begin_timestamp:datetime',
        'deadline_timestamp:datetime',
        //'end_timestamp:datetime',
        //'admin_id',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn',     'controller' => 'task',
        ],
    ],
]); ?>

<h3>Закрытые за последнюю неделю: </h3>
<?= GridView::widget([
    'dataProvider' => $dataProviderLastWeekEndedTasks,
    'filterModel' => $searchModelLastWeekEndedTasks,
    'rowOptions' => function ($model) {
        if ($model->deadline_timestamp < time()) {
            return ['class' => 'danger'];
        } elseif ($model->end_timestamp) {
            return ['class' => 'success'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'user.login',
        'begin_timestamp:datetime',
        'deadline_timestamp:datetime',
        //'end_timestamp:datetime',
        //'admin_id',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn',     'controller' => 'task',
        ],
    ],
]); ?>

<h3>Просроченные: </h3>
<?= GridView::widget([
    'dataProvider' => $dataProviderOverdueTasks,
    'filterModel' => $searchModelOverdueTasks,
    'rowOptions' => function ($model) {
        if ($model->deadline_timestamp < time()) {
            return ['class' => 'danger'];
        } elseif ($model->end_timestamp) {
            return ['class' => 'success'];
        }
    },
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'title',
        'user.login',
        'begin_timestamp:datetime',
        'deadline_timestamp:datetime',
        //'end_timestamp:datetime',
        //'admin_id',
        //'created_at',
        //'updated_at',

        ['class' => 'yii\grid\ActionColumn',     'controller' => 'task',
        ],
    ],
]); ?>
