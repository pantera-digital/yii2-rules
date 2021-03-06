<?php

namespace pantera\rules\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "system_rule_action_log".
 *
 * @property integer $id
 * @property integer $action_id
 * @property integer $primary_key
 * @property integer $user_id
 * @property integer $status
 * @property string $message
 * @property string $created_at
 *
 * @property RuleAction $action
 * @property mixed $user
 */
class RuleActionLog extends ActiveRecord
{
    public function getStatusName()
    {
        return [
            0 => 'Fail',
            1 => 'Success',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_rule_action_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action_id'], 'required'],
            [['action_id', 'primary_key', 'user_id', 'status'], 'integer'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [
                ['action_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => RuleAction::class,
                'targetAttribute' => ['action_id' => 'id']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action_id' => 'Action ID',
            'primary_key' => 'Primary Key',
            'user_id' => 'User ID',
            'status' => 'Status',
            'message' => 'Message',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(RuleAction::class, ['id' => 'action_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(get_class(Yii::$app->user->identity), ['id' => 'user_id']);
    }
}
