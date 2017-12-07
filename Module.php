<?php

namespace pantera\rules;

use Yii;
use yii\helpers\StringHelper;

class Module extends \yii\base\Module
{
    public $classes;
    public $classesList;

    public function init()
    {
        $classesListKeys = array_keys($this->classes);
        $classesListValues = array_keys($this->classes);
        array_walk($classesListValues, function (&$item) {
            $item = StringHelper::basename($item);
        });
        $this->classesList = array_combine($classesListKeys, $classesListValues);
        EventsListener::init();
        parent::init();
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