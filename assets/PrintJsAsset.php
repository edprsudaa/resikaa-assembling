<?php

namespace app\assets;

class PrintJsAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/print.js-1.5.0/print.min.css',
    ];
    public $js = [
        'plugins/print.js-1.5.0/print.min.js',
    ];
    public $depends = [];
}
