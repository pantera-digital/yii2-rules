<?php

use yii\db\Migration;

/**
 * Handles the creation of table `system_rule`.
 */
class m171115_011552_create_system_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%system_rule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'event' => $this->string()->notNull(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'comment' => $this->text()->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%system_rule}}');
    }
}
