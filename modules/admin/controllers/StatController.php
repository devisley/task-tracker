<?php
/**
 * Created by PhpStorm.
 * User: Ruslan
 * Date: 07.12.2018
 * Time: 0:13
 */

namespace app\modules\admin\controllers;

use Yii;
use app\models\TaskSearch;

class StatController extends AdminController
{
    public function actionIndex()
    {
        $searchModelAllTasks = new TaskSearch();
        $searchModelAllTasks->whereCondition = ['admin_id' => Yii::$app->user->id];
        $dataProviderAllTasks = $searchModelAllTasks->search(Yii::$app->request->queryParams);

        $searchModelLastWeekEndedTasks = new TaskSearch();
        $searchModelLastWeekEndedTasks->whereCondition = ['and', 'admin_id=' . Yii::$app->user->id, ['>=', 'end_timestamp', strtotime("-1 week")]];
        $dataProviderLastWeekEndedTasks = $searchModelLastWeekEndedTasks->search(Yii::$app->request->queryParams);

        $searchModelOverdueTasks = new TaskSearch();
        $searchModelOverdueTasks->whereCondition = ['and', 'admin_id=' . Yii::$app->user->id, ['<', 'deadline_timestamp', time()]];
        $dataProviderOverdueTasks = $searchModelOverdueTasks->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelAllTasks' => $searchModelAllTasks,
            'dataProviderAllTasks' => $dataProviderAllTasks,
            'searchModelLastWeekEndedTasks' => $searchModelLastWeekEndedTasks,
            'dataProviderLastWeekEndedTasks' => $dataProviderLastWeekEndedTasks,
            'searchModelOverdueTasks' => $searchModelOverdueTasks,
            'dataProviderOverdueTasks' => $dataProviderOverdueTasks,
        ]);
    }
}