<?php
$params = require(__DIR__.'/params.php');
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'asjdkljeoiqwueoijcmnvhjkfh',
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@app/mail',
            'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'mail.ifomania.ru',
				'username' => 'help@test.ru',
				'password' => 'test',
				'port' => '25',
				
//				'encryption' => 'tls',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__.'/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
			'enableStrictParsing' => true, // надо true для того что когда урла не будет, будет выбрашено исключение, иначе будет пытаться искать соответствующее действие
			//'suffix' => '.html',
            'rules' => [
				''									=> 'site/index',
				'<slug:[a-z0-9_-]+_[1-9][0-9]*>'	=> 'site/product',
                
				// admin
				'admin'											=> 'admin/index',
				
				'GET,POST admin/products/create'				=> 'admin/product-update',
				'GET,POST admin/products/<id:[1-9][0-9]*>/edit'	=> 'admin/product-update',
				'DELETE admin/products/<id:[1-9][0-9]*>/delete'	=> 'admin/product-delete',
				'DELETE admin/products/<id:[1-9][0-9]*>/<name:[\d]+_[\d]+.(jpg|jpeg|png)>/delete' => 'admin/product-image-delete',
				
				'GET,POST admin/comments/create'				=> 'admin/comment-update',
				'GET,POST admin/comments/<id:[1-9][0-9]*>/edit'	=> 'admin/comment-update',
				'DELETE admin/comments/<id:[1-9][0-9]*>/delete'	=> 'admin/comment-delete',
				
				'GET,POST admin/pages/create'					=> 'admin/page-update',
				'GET,POST admin/pages/<id:[1-9][0-9]*>/edit'	=> 'admin/page-update',
				'DELETE admin/pages/<id:[1-9][0-9]*>/delete'	=> 'admin/page-delete',
				
				'admin/orders/<id:[1-9][0-9]*>'					=> 'admin/get-order',
				'GET,POST admin/login'							=> 'admin/login',
				'POST admin/upload-image'						=> 'admin/upload-image',
				
				'GET,POST admin/settings/<id:[1-9][0-9]*>/edit'	=> 'admin/setting-update',
				
				'admin/users/<id:[1-9][0-9]*>/edit'				=> 'admin/user-update',
				
				'admin/<action>'								=> 'admin/<action>',
				
				// profile
				'profile'							=> 'profile/index',
				'POST profile/set-avatar'			=> 'profile/set-avatar',
				[
					'pattern'	=> 'profile/create-order-on-get-gift',
					'route'		=> 'profile/create-order-on-get-gift',
					'suffix'	=> '.json',
				],
				'profile/<action>'					=> 'profile/<action>',
				
				// site
				'page/<slug:[-a-z0-9_.]+>'			=> 'site/page',
				
				[
					'pattern'	=> 'login',
					'route'		=> 'site/login',
					'suffix'	=> '.json',
				],
				[
					'pattern'	=> 'registration',
					'route'		=> 'site/registration',
					'suffix'	=> '.json',
				],
				[
					'pattern'	=> 'add-to-cart',
					'route'		=> 'site/add-to-cart',
					'suffix'	=> '.json',
				],
				[
					'pattern'	=> 'remove-from-cart',
					'route'		=> 'site/remove-from-cart',
					'suffix'	=> '.json',
				],
				[
					'pattern'	=> 'update-amount-cart',
					'route'		=> 'site/update-amount-cart',
					'suffix'	=> '.json',
				],
				[
					'pattern'	=> 'add-order',
					'route'		=> 'site/add-order',
					'suffix'	=> '.json',
				],
				
				'<action>' => 'site/<action>',
            ],
        ],
    ],
    'params' => $params,
	'timeZone' => 'Europe/Moscow',
	'version' => '1.0',
	'language' => 'ru'
	//'on beforeAction' => function ($event) {},
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
