<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Team */
/* @var $form ActiveForm */
?>
<h2>Создайте свою команду</h2>
<div class="team-index">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->input('text', ['class' => 'form-control my']) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- team-index -->

