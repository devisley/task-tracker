<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 01.12.2018
 * Time: 11:55
 */

namespace app\modules\admin\controllers;

use app\models\Invite;
use app\models\Task;
use app\models\TaskSearch;
use app\models\Team;
use app\models\TeamMember;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;

class TeamController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * View team action for admin.
     *
     * @param $id - Team id
     * @return string
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect(Url::toRoute('site/login'));
        }

        $model = Team::findOne($id);
        if ($model->admin === Yii::$app->user->id) {
            $searchModel = new TaskSearch();
            $searchModel->whereCondition = ['admin_id' => Yii::$app->user->id, 'team_id' => $id];
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            return $this->redirect(Url::toRoute(['/admin']));
        }


        $teamMembers = TeamMember::findAll(['team_id' => $id]);
        $members = [];
        $membersNames = [];
        foreach ($teamMembers as $member) {
            $user = $member->user;
            array_push($members, $user);
            $membersNames[$user->id] = $user->login;
        }

        $login = Yii::$app->request->post('login');
        //Если мы пригласили нового участника в команду
        if ($login) {
            $user = User::findByUsername($login);
            if ($user) {
                if (TeamMember::findOne(['user_id' => $user->id, 'team_id' => $model->id])) {
                    Yii::$app->session->setFlash('warning', 'Пользователь уже был добавлен! ');
                } else if (Invite::findOne([
                    'subj_id' => Yii::$app->user->id,
                    'obj_id' => $user->id,
                    'team_id' => $model->id
                    ])) {

                    Yii::$app->session->setFlash('warning', 'Приглашение уже было отправлено! ');
                } else {
                    $invite = new Invite();
                    $invite->subj_id = Yii::$app->user->id;
                    $invite->obj_id = $user->id;
                    $invite->team_id = $model->id;

                    $invite->text = Yii::$app->request->post('text');

                    if ($invite->save()) {
                        Yii::$app->session->setFlash('success', 'Приглашение отправлено! ');
                    } else {
                        Yii::$app->session->setFlash('error', 'Приглашение не отправлено! ');
                    }
                }

            } else {
                Yii::$app->session->setFlash('error', 'Пользователь не найден! ');
            }
        }

        return $this->render('view', [
            'model' => $model,
            'members' => $members,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'taskModel' => new Task(),
            'membersNames' => $membersNames
        ]);
    }

}