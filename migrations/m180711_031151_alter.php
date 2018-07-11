<?php

use yii\db\Migration;

/**
 * Class m180711_031151_alter
 */
class m180711_031151_alter extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameColumn('{{%system_rule}}', 'model', 'class');

        $this->alterColumn('{{%system_rule_action_log}}', 'model_id', $this->integer()->null());
        $this->renameColumn('{{%system_rule_action_log}}', 'model_id', 'primary_key');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameColumn('{{%system_rule}}', 'class', 'model');

        $this->renameColumn('{{%system_rule_action_log}}', 'primary_key', 'model_id');
        $this->alterColumn('{{%system_rule_action_log}}', 'model_id', $this->integer()->notNull());
        return true;
    }
}
