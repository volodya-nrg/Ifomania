<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'vendor/bootstrap/css/bootstrap.min.css',
		'vendor/font-awesome-4.7.0/css/font-awesome.min.css',
		'vendor/slick/slick.css',
		'vendor/slick/slick-theme.css',
		'vendor/fancyBox/source/jquery.fancybox.css',
		'css/main.css',
    ];
    public $js = [
		'vendor/jquery/jquery-3.1.1.min.js',
		'vendor/bootstrap/js/bootstrap.min.js',
		'vendor/slick/slick.min.js',
		'vendor/fancyBox/source/jquery.fancybox.js',
		'vendor/jquery/jquery.maskedinput.min.js',
		'js/main.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
	//public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}