<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class EditAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fileinput/css/fileinput.min.css',
    ];
    public $js = [
        'js/eModal.min.js',  //模态框

        'fileinput/js/plugins/canvas-to-blob.min.js',
        'fileinput/js/fileinput.min.js',
        '//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js',
        'fileinput/js/locales/zh.js',

        'fileinput/js/upload.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}














