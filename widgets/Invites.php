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

class Invites extends Widget
{
    public $invites;

    public function run()
    {
        echo Html::beginTag('ul', ['class' => 'invites']);
        foreach ($this->invites as $invite) {
            echo Html::beginTag('li', ['class' => 'invites__item']);

            echo $this->render('invite', [
                'author' => $invite->author,
                'text' => $invite->text,
                'teamId' => $invite->team_id,
                'inviteId' => $invite->id,
            ]);
            echo Html::endTag('li');
        }
        echo Html::endTag('ul');
    }

}