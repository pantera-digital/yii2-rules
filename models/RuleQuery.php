<?php

namespace pantera\rules\models;

class RuleQuery extends \yii\db\ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['=', '{{%system_rule}}.status', 1]);
    }

    /**
     * @inheritdoc
     * @return Rule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Rule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
