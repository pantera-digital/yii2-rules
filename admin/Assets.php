<?php

namespace pantera\rules\admin;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Assets extends AssetBundle
{
    public $sourcePath = '@vendor/pantera-digital/yii2-rules/admin/assets';
    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/ace/ace.js',
        'js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}