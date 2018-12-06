<?php

namespace app\controllers;

use app\models\Invite;
use app\models\RegistryForm;
use app\models\Team;
use app\models\TeamMember;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;

class SiteController extends FrontendController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'cabinet'],
                'rules' => [
                    [
                        'actions' => ['logout', 'cabinet'],
                        'allow' => true,
                        'roles' => ['admin', 'simple'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::toRoute('site/cabinet'));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegistry() {

        $model = new RegistryForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->setAttributes($model->getAttributes());
            $user->password = $user->getPasswordHash($user->password);

            if ($user->save()) {
                $auth = \Yii::$app->authManager;
                $simple = $auth->getRole('simple');
                //Связываем роль с пользователем
                try {
                    $auth->assign($simple, $user->getPrimaryKey());
                } catch (\Exception $exception)
                {
                    echo 'Ошибка при создании роли'.PHP_EOL;
                }
                return $this->redirect('login');
            }
        }

        return $this->render('registry', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays user cabinet.
     *
     * @return string
     */
    public function actionCabinet()
    {
        $invites = Invite::findAllInvites(Yii::$app->user->id);
        foreach ($invites as $invite) {
            $user = User::findOne(['id' => $invite->subj_id]);
            if ($user) {
                $invite->author = $user->login;
            }
        }

        $adminTeams = Team::findAll(['admin' => Yii::$app->user->id]);
        $teams = TeamMember::findAll(['user_id' => Yii::$app->user->id]);
        $memberTeams = [];
        foreach ($teams as $team) {
            array_push($memberTeams, $team->team);
        }

        return $this->render('cabinet', [
            'invites' => $invites,
            'adminTeams' => $adminTeams,
            'memberTeams' => $memberTeams
        ]);
    }
}
