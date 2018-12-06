<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team_member".
 *
 * @property int $user_id
 * @property int $team_id
 *
 * @property Team $team
 * @property User $user
 */
class TeamMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'team_id'], 'required'],
            [['user_id', 'team_id'], 'integer'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'team_id' => 'Team ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

//    /**
//     * @param $teamId Team id
//     * @return \yii\db\ActiveQuery
//     */
//    public function getAllTeamMembers($teamId)
//    {
//        $teams = static::findAll(['user_id' => Yii::$app->user->id]);
//        $memberTeams = [];
//        foreach ($teams as $team) {
//            array_push($memberTeams, $team->team);
//        }
//    }

//    /**
//     * @param $userId User id
//     * @return \yii\db\ActiveQuery
//     */
//    public function getAllUserTeams($userId)
//    {
//        $teams = static::findAll(['user_id' => Yii::$app->user->id]);
//        $memberTeams = [];
//        foreach ($teams as $team) {
//            array_push($memberTeams, $team->team);
//        }
//    }
}
