<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 01.12.2018
 * Time: 11:55
 */

namespace app\controllers;

use app\models\Invite;
use app\models\Task;
use app\models\TaskSearch;
use app\models\Team;
use app\models\TeamMember;
use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;

class TeamController extends FrontendController
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
                        'roles' => ['simple', 'admin'],
                    ],
                ],
            ],
        ];
    }
    /**
     *  Index team action.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute('site/login'));
        }

        $model = new Team();
        $model->admin = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Команда создана! ');
                $this->redirect(Url::toRoute(['team/view', 'id' => $model->getPrimaryKey()]));
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при создании команды! ');
                return $this->render('index');
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * View team action.
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
        //Если пользователь - администратор группы
        if ($model->admin === Yii::$app->user->id) {
            //Если я админ, то
            $auth = \Yii::$app->authManager;

            $admin = $auth->getRole('admin');
            $currentRoleIsAdmin = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)['admin'];

            if(!$currentRoleIsAdmin) {
                //Связываем роль администратора группы с пользователем
                try {
                    $auth->revokeAll(Yii::$app->user->id);
                    $auth->assign($admin, Yii::$app->user->id);
                } catch (\Exception $exception)
                {
                    echo 'Ошибка при создании роли'.PHP_EOL;
                }
            }

            return $this->redirect(Url::toRoute(['/admin/team/view', 'id' => $id]));
        } else if (TeamMember::findOne(['user_id' => Yii::$app->user->id, 'team_id' => $id])){
            //Если я участник
            $searchModel = new TaskSearch();
            $searchModel->whereCondition = ['user_id' => Yii::$app->user->id, 'team_id' => $id];
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            Yii::$app->session->setFlash('warning', 'Вы не являетесь членом этой команды! ');
            return $this->redirect(['/site/cabinet']);
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
        ]);
    }

    /**
     * Join to the team action.
     *
     * @param $teamId - Team id
     * @param $inviteId - Invite id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionJoin($teamId, $inviteId)
    {
        $member = new TeamMember();
        $member->user_id = Yii::$app->user->id;
        $member->team_id = $teamId;

        if ($member->save()) {
            Yii::$app->session->setFlash('success', 'Вы вступили в команду! ');
            $invite = Invite::findOne($inviteId);
            if ($invite) {
                $invite->delete();
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка добавления в команду! ');
            return $this->goBack();
        }

        $this->redirect(Url::toRoute(['site/cabinet']));
    }
}