<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 01.12.2018
 * Time: 21:09
 */
?>

<div>
    <p>
        <b>Id: </b><?=$id?>
        <b>Title: </b><?=$title?>
    </p>
    <a href="<?= \yii\helpers\Url::toRoute(['team/view', 'id' => $id])?>" class="btn btn-success">Посмотреть</a>
</div>
