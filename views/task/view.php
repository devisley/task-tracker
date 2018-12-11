<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */

$this->title = $model->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Modal::begin([
    'header' => '<h3>Отчет о завершении задачи</h3>',
    'toggleButton' => ['label' => 'Отчитаться о завершении', 'class' => 'btn btn-success'],
    ]);?>
    <form method="post" action="<?=\yii\helpers\Url::toRoute(['task/end', 'id' => $model->id])?>">
        <label>
            <textarea name="endReport" cols="80" rows="5" placeholder="Текст отчета" class="form-control rounded-0"></textarea>
        </label>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>"><br>
        <button type="submit" class="btn btn-primary">Отправить отчет</button>
    </form>
    <?php Modal::end();?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text',
            'user.login',
            'begin_timestamp:datetime',
            'deadline_timestamp:datetime',
            'end_timestamp:datetime',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
