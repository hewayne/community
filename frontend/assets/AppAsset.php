<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/buttons.css', //按钮样式库
        'css/site.css',
    ];
    public $js = [
        '//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js',
        'js/eModal.min.js',  //模态框
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
