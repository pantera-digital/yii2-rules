<?php

namespace pantera\rules;

use Yii;
use yii\helpers\StringHelper;

class Module extends \yii\base\Module
{
    public $classes = [];
    public $classesList = [];

    public function init()
    {
        if ($this->isInstalled()) {
            $classesListKeys = array_keys($this->classes);
            $classesListValues = array_keys($this->classes);
            array_walk($classesListValues, function (&$item) {
                $item = StringHelper::basename($item);
            });
            $this->classesList = array_combine($classesListKeys, $classesListValues);
            EventListener::init();
        }
        parent::init();
    }

    public function isInstalled()
    {
        return Yii::$app->db->schema->getTableSchema('{{%system_rule}}') !== null;
    }

    public function getEventsOfClass($model)
    {
        $result = [];
        if (array_key_exists($model, $this->classes)) {
            $result = array_combine($this->classes[$model], $this->classes[$model]);
        }
        return $result;
    }
}
