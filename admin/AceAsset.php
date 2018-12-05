<?php

namespace pantera\rules\admin;

use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    public $sourcePath = '@npm/ace-builds';

    public $js = [
        'src-min/ace.js'
    ];
}
