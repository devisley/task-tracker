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

class Members extends Widget
{
    public $members;

    public function run()
    {
        echo Html::beginTag('ul', ['class' => 'team']);
        foreach ($this->members as $member) {
            echo Html::beginTag('li', ['class' => 'team__item']);
            echo $member->login;
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
    }

}