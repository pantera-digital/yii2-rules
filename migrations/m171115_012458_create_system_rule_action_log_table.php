<?php

use yii\db\Migration;

/**
 * Handles the creation of table `system_rule_action_log`.
 * Has foreign keys to the tables:
 *
 * - `system_rule_action`
 */
class m171115_012458_create_system_rule_action_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%system_rule_action_log}}', [
            'id' => $this->primaryKey(),
            'action_id' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'message' => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `action_id`
        $this->createIndex(
            'idx-system_rule_action_log-action_id',
            '{{%system_rule_action_log}}',
            'action_id'
        );

        // add foreign key for table `system_rule_action`
        $this->addForeignKey(
            'fk-system_rule_action_log-action_id',
            '{{%system_rule_action_log}}',
            'action_id',
            '{{%system_rule_action}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-system_rule_action_log-user_id',
            '{{%system_rule_action_log}}',
            'user_id'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `rules_actions`
        $this->dropForeignKey(
            'fk-system_rule_action_log-action_id',
            '{{%system_rule_action_log}}'
        );

        // drops index for column `action_id`
        $this->dropIndex(
            'idx-system_rule_action_log-action_id',
            '{{%system_rule_action_log}}'
        );

        $this->dropTable('{{%system_rule_action_log}}');
    }
}
