<?php

namespace pantera\rules\models;

use himiklab\sortablegrid\SortableGridBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "system_rule_action".
 *
 * @property integer $id
 * @property integer $rule_id
 * @property string $php_code
 * @property integer $sort
 * @property integer $status
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 *
 * @property Rule $rule
 * @property RuleActionLog[] $ruleActionLogs
 */
class RuleAction extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::className(),
                'sortableAttribute' => 'sort'
            ],
        ];
    }

    public function getStatusName()
    {
        return [
            0 => 'Not active',
            1 => 'Active',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_rule_action}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rule_id', 'name'], 'required'],
            [['rule_id', 'sort', 'status'], 'integer'],
            [['php_code', 'comment'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['rule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rule::className(), 'targetAttribute' => ['rule_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rule_id' => 'Rule ID',
            'php_code' => 'Php Code',
            'sort' => 'Sort',
            'status' => 'Status',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRule()
    {
        return $this->hasOne(Rule::className(), ['id' => 'rule_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleActionLogs()
    {
        return $this->hasMany(RuleActionLog::className(), ['action_id' => 'id']);
    }
}
