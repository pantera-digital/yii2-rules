<?php
/**
 * Created by PhpStorm.
 * User: singletonn
 * Date: 11/15/17
 * Time: 11:12 AM
 */

namespace pantera\rules;

use pantera\rules\models\Rule;
use pantera\rules\models\RuleAction;
use pantera\rules\models\RuleActionLog;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;

class EventListener
{

    public static function init()
    {
        $rules = Rule::find()
            ->joinWith(['actions'])
            ->active()
            ->all();
        foreach ($rules as $rule) {
            foreach ($rule->actions as $action) {
                self::bind($action);
            }
        }
    }

    public static function bind(RuleAction $action)
    {
        Event::on($action->rule->class, $action->rule->event, function ($event) use ($action) {
            $status = 1;
            $stackTrace = null;
            $model = $event->sender;
            if (Yii::$app->has("user")) {
                /** @noinspection PhpUnusedLocalVariableInspection */
                $user = Yii::$app->user->identity;
            }
            try {
                eval($action->php_code);
            } catch (\Exception $exception) {
                $status = 0;
                $stackTrace = $exception->getTraceAsString();
            }
            self::log($action, $model, $status, $stackTrace);
        });
    }

    private static function log(RuleAction $action, $model, $status, $stackTrace)
    {
        $log = new RuleActionLog();
        $log->action_id = $action->id;
        if ($model instanceof ActiveRecord) {
            $log->primary_key = $model->getPrimaryKey();
        }
        $log->status = $status;
        $log->message = $stackTrace;
        if (Yii::$app->has("user")) {
            $log->user_id = Yii::$app->user->id;
        }
        $log->save();
    }

}