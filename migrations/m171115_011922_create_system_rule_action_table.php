<?php

use yii\db\Migration;

/**
 * Handles the creation of table `system_rule_action`.
 * Has foreign keys to the tables:
 *
 * - `rules`
 */
class m171115_011922_create_system_rule_action_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%system_rule_action}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'rule_id' => $this->integer()->notNull(),
            'php_code' => $this->text()->null(),
            'sort' => $this->integer()->null(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'comment' => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);

        // creates index for column `rule_id`
        $this->createIndex(
            'idx-system_rule_action-rule_id',
            '{{%system_rule_action}}',
            'rule_id'
        );

        // add foreign key for table `rules`
        $this->addForeignKey(
            'fk-system_rule_action-rule_id',
            '{{%system_rule_action}}',
            'rule_id',
            '{{%system_rule}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `rules`
        $this->dropForeignKey(
            'fk-system_rule_action-rule_id',
            '{{%system_rule_action}}'
        );

        // drops index for column `rule_id`
        $this->dropIndex(
            'idx-system_rule_action-rule_id',
            '{{%system_rule_action}}'
        );

        $this->dropTable('{{%system_rule_action}}');
    }
}
