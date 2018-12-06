<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 29.11.2018
 * Time: 23:15
 */
use yii\bootstrap\Html;
?>

<article>
    <h4>Сообщение от: <?= $author?></h4>
    <p><?=$text?></p>
    <a href="<?= \yii\helpers\Url::toRoute(['team/join', 'teamId' => $teamId, 'inviteId' => $inviteId])?>" class="btn btn-success">Вступить</a>
</article>
