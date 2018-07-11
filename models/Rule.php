<?php

namespace pantera\rules\models;

/**
 * This is the model class for table "system_rule".
 *
 * @property integer $id
 * @property string $name
 * @property string $class
 * @property string $event
 * @property integer $status
 * @property string $comment
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RuleAction[] $actions
 */
class Rule extends \yii\db\ActiveRecord
{
    public function getStatusName()
    {
        return [
            1 => 'Active',
            0 => 'Not active',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class', 'event', 'name'], 'required'],
            [['comment'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['class', 'event', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'class' => 'class',
            'event' => 'Event',
            'status' => 'Status',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function find(){
        return new RuleQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActions()
    {
        return $this->hasMany(RuleAction::className(), ['rule_id' => 'id']);
    }
}
