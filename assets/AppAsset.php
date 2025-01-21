<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/jstree/dist/themes/default/style.min.css',
        "plugins/atjs/dist/css/jquery.atwho.min.css",
        'plugins/typeahead/typeahead.css',
        'css/app.css',
        'css/site.css',
    ];
    public $js = [
        'js/site.js',
        'js/app.js',
        'plugins/jstree/dist/jstree.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
