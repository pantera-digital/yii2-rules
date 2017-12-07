<?php

namespace pantera\rules\admin;

use pantera\rules\admin\Assets;
use Yii;

class BackendModule extends Module
{
    public $permissions;
    public $controllerNamespace = 'pantera\rules\admin\controllers';

    public function getViewPath()
    {
        return __DIR__ . '/admin/views';
    }

    public function init()
    {
        Assets::register(Yii::$app->view);
        parent::init();
    }
}