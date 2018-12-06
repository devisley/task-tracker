<?php

use yii\db\Migration;

/**
 * Handles the creation of table `invite`.
 */
class m181129_190736_create_invite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('invite', [
            'id' => $this->primaryKey(),
            'subj_id' => $this->integer()->notNull(),
            'obj_id' => $this->integer()->notNull(),
            'team_id' => $this->integer()->notNull(),
            'text' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('invite');
    }
}
