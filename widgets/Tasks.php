<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 29.11.2018
 * Time: 23:04
 */

namespace app\widgets;

use yii\base\Widget;
use yii\bootstrap\Html;

class Tasks extends Widget
{
    public $tasks;

    public function run()
    {
        echo Html::beginTag('ul', ['class' => 'task']);
        foreach ($this->tasks as $task) {
            echo Html::beginTag('li', ['class' => 'task__item']);
            echo $this->render('task', [
                'task' => $task,
            ]);
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
    }

}