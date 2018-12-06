<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 01.12.2018
 * Time: 13:23
 */
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

?>

<h2><?=$model->title?></h2>

<h3>Участники: </h3>
<?php if(count($members)): ?>
    <?= \app\widgets\Members::widget(['members' => $members]) ?>
<?php else: ?>
    <?= 'Участников нет' ?>
<?php endif; ?>
<?php
Modal::begin([
    'header' => '<h3>Отправка инвайта</h3>',
    'toggleButton' => ['label' => 'Добавить участника', 'class' => 'btn btn-success'],
]);?>
<form method="post">
    <label>
        <span>Логин</span>
        <input type="text" name="login" class="form-control rounded-0" required>
    </label>
    <br>
    <label>
        <textarea name="text" cols="80" rows="5" placeholder="Текст сообщения" class="form-control rounded-0"></textarea>
    </label>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>"><br>
    <button type="submit" class="btn btn-primary">Отправить приглашение</button>
</form>
<?php Modal::end();?>
<hr>
<h3>Задачи: </h3>
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

<?php
Modal::begin([
    'header' => '<h3>Добавление задачи</h3>',
    'toggleButton' => ['label' => 'Добавить задачу', 'class' => 'btn btn-success'],
]);?>

<div class="team-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => \yii\helpers\Url::toRoute(['task/add-task', 'teamId' => $model->id]),
    ]); ?>

    <?= $form->field($taskModel, 'title') ?>
    <?= $form->field($taskModel, 'user_id')->dropDownList($membersNames) ?>
    <?= $form->field($taskModel, 'deadline_timestamp')->input('date', ['min' => date("Y-m-d")]) ?>
    <?= $form->field($taskModel, 'text')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- team-form -->

<?php Modal::end();?>
