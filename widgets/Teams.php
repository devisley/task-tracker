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

class Teams extends Widget
{
    public $teams;

    public function run()
    {
        echo Html::beginTag('ul', ['class' => 'team']);
        foreach ($this->teams as $team) {
            echo Html::beginTag('li', ['class' => 'team__item']);

            echo $this->render('team', [
                'id' => $team->id,
                'title' => $team->title,
            ]);
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
    }

}