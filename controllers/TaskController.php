<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 02.12.2018
 * Time: 13:58
 */

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class TaskController extends FrontendController
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
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Завершили задачу
     * @param $id
     * @return \yii\web\Response
     */
    public function actionEnd($id)
    {
        $model = Task::findOne($id);
        if ($model->end_timestamp) {
            Yii::$app->session->setFlash('warning', 'Задача уже отмечена как завершенная');
        } else {
            $model->end_timestamp = time();
            $model->end_comment = Yii::$app->request->post('endReport');
            $model->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}