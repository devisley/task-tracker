<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m181202_081855_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'team_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'admin_id' => $this->integer()->notNull(),
            'begin_timestamp' => $this->integer()->notNull(),
            'deadline_timestamp' => $this->integer()->notNull(),
            'end_timestamp' => $this->integer(),
            'end_comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('task_user-user', 'task', 'user_id', 'user', 'id');
        $this->addForeignKey('task_admin-user', 'task', 'admin_id', 'user', 'id');
        $this->addForeignKey('task_team-team', 'task', 'team_id', 'team', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('task_user-user', 'task');
        $this->dropIndex('task_user-user', 'task');
        $this->dropForeignKey('task_admin-user', 'task');
        $this->dropIndex('task_admin-user', 'task');
        $this->dropTable('task');
    }
}
