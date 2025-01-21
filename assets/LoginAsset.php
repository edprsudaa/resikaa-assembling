<?php

namespace app\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/iofrm/css/fontawesome-all.min.css',
        'plugins/iofrm/css/iofrm-style.css',
        'plugins/iofrm/css/iofrm-theme4.css',
    ];
    public $js = [
        'plugins/iofrm/js/main.js',
    ];
    public $depends = [];
}
