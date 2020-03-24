<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
	
    public $css = [
		'vendor/bootstrap/css/bootstrap.min.css',
		'vendor/font-awesome-4.7.0/css/font-awesome.min.css',
//		'vendor/slick/slick.css',
//		'vendor/slick/slick-theme.css',
		'css/admin.css',
    ];
    public $js = [
		'vendor/jquery/jquery-3.1.1.min.js',
//		'vendor/underscore/underscore-min.js',
		'vendor/bootstrap/js/bootstrap.min.js',
		'vendor/ckeditor/ckeditor.js',
//		'vendor/slick/slick.min.js',
		'js/admin.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}