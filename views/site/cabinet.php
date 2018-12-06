<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 29.11.2018
 * Time: 22:21
 */
?>

<h1>Личный кабинет</h1>
<div class="invite-box">
    <h3>Приглашения:</h3>

    <?php if(count($invites)): ?>
        <?= \app\widgets\Invites::widget(['invites' => $invites]) ?>
    <?php else: ?>
        <?= 'Приглашений нет' ?>
    <?php endif; ?>
</div>
<hr>
<div class="admin-team-box">
    <h2>Созданные команды: </h2>
    <?php if(count($adminTeams)): ?>
        <?= \app\widgets\Teams::widget(['teams' => $adminTeams]) ?>
    <?php else: ?>
        <?= 'Нет созданных команд' ?>
    <?php endif; ?>
    <a href="<?=\yii\helpers\Url::toRoute('team/index')?>" class="btn btn-info">Создать команду!</a>
</div>
<hr>
<div class="member-team-box">
    <h2>Участие в командах </h2>
    <?php if(count($memberTeams)): ?>
        <?= \app\widgets\Teams::widget(['teams' => $memberTeams]) ?>
    <?php else: ?>
        <?= 'Не состоите в командах' ?>
    <?php endif; ?>
</div>


