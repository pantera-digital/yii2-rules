<?php

namespace pantera\rules\admin;

use pantera\rules\admin\Assets;
use Yii;

class Module extends \pantera\rules\Module
{
    public $permissions;
    public $controllerNamespace = 'pantera\rules\admin\controllers';

    public function getViewPath()
    {
        return __DIR__ . '/views';
    }

    public function init()
    {
        Assets::register(Yii::$app->view);
        parent::init();
    }
}