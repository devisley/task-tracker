<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team_member`.
 */
class m181129_210620_create_team_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('team_member', [
            'user_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('team_member_user-user', 'team_member', 'user_id', 'user', 'id');
        $this->addForeignKey('team_member_team-team', 'team_member', 'team_id', 'team', 'id');

        $this->createIndex('idx-user_id', 'team_member', 'user_id');
        $this->createIndex('idx-team_id', 'team_member', 'team_id');
        $this->addPrimaryKey('team_member_pk', 'team_member', ['user_id', 'team_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropIndex('idx-user_id', 'team_member');
//        $this->dropIndex('idx-team_id', 'team_member');
//        $this->dropPrimaryKey('team_member_pk', 'team_member');
//        $this->dropForeignKey('team_member_user-user', 'team_member');
//        $this->dropIndex('team_member_user-user', 'team_member');
//        $this->dropForeignKey('team_member_team-team', 'team_member');
//        $this->dropIndex('team_member_team-team', 'team_member');

        $this->dropTable('team_member');
    }
}
