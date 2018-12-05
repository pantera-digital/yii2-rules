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

    public function getEventsOfClass($class)
    {
        $result = [];
        if (array_key_exists($class, $this->classes)) {
            $result = array_combine($this->classes[$class], $this->classes[$class]);
        }
        return $result;
    }

    public function getMenuItems()
    {
        return [
            [
                'label' => 'Rules',
                'url' => '#',
                'icon' => 'cogs',
                'items' => [
                    ['label' => 'Rules', 'url' => ['/rules/rules']],
                    ['label' => 'Rules actions log', 'url' => ['/rules/rules-actions-log']],
                ]
            ]
        ];
    }
}
