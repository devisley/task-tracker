<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m181129_205306_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'admin' => $this->integer()
        ]);

        $this->addForeignKey('invite_subj-user', 'invite', 'subj_id', 'user', 'id');
        $this->addForeignKey('invite_obj-user', 'invite', 'obj_id', 'user', 'id');
        $this->addForeignKey('invite_team-user', 'invite', 'team_id', 'team', 'id');
        $this->addForeignKey('team_admin-user', 'team', 'admin', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('invite_subj-user', 'invite');
        $this->dropIndex('invite_subj-user', 'invite');
        $this->dropForeignKey('invite_obj-user', 'invite');
        $this->dropIndex('invite_obj-user', 'invite');
        $this->dropForeignKey('invite_team-user', 'invite');
        $this->dropIndex('invite_team-user', 'invite');
        $this->dropForeignKey('team_admin-user', 'team');
        $this->dropIndex('team_admin-user', 'team');
        $this->dropTable('team');
    }
}
