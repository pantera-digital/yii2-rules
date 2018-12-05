<?php

namespace pantera\rules\admin;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Assets extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/script.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        AceAsset::class,
    ];
}
