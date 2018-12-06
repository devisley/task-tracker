<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invite".
 *
 * @property int $id
 * @property int $subj_id
 * @property int $obj_id
 * @property int $team_id
 * @property string $text
 *
 * @property User $obj
 * @property User $subj
 */
class Invite extends \yii\db\ActiveRecord
{
    public $author;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subj_id', 'obj_id', 'team_id'], 'required'],
            [['subj_id', 'obj_id', 'team_id'], 'integer'],
            [['text'], 'string'],
            [['obj_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['obj_id' => 'id']],
            [['subj_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['subj_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subj_id' => 'Subj ID',
            'obj_id' => 'Obj ID',
            'team_id' => 'Team ID',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObj()
    {
        return $this->hasOne(User::className(), ['id' => 'obj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubj()
    {
        return $this->hasOne(User::className(), ['id' => 'subj_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    public static function findAllInvites($userId) {
        return static::findAll(['obj_id' => $userId]);
    }
}
