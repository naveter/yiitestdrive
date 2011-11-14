<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii Blog Demo',
        //'theme'=>'themename',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.extensions.yiidebugtb.*',
	),

	'defaultController'=>'post',

        'modules'=>array(
            'gii'=>array(
                'class'=>'system.gii.GiiModule',
                'password'=>'123456',
                // 'ipFilters'=>array(…список IP…),
                // 'newFileMode'=>0666,
                // 'newDirMode'=>0777,
            ),
        ),

	// application components
	'components'=>array(
           // отключение кеширования скриптов и стилей
           'assetManager' => array(
             'linkAssets' => true,
           ),

            'user'=>array(
                    // enable cookie-based authentication
                    'allowAutoLogin'=>true,
            ),

            'db'=>array(
                    'connectionString' => 'mysql:host=localhost;dbname=blog',
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => '123456',
                    'charset' => 'utf8',
                    'tablePrefix' => 'tbl_',
            ),

            'errorHandler'=>array(
                    // use 'site/error' action to display errors
                    'errorAction'=>'site/error',
            ),
            /*
            'urlManager'=>array(
                'urlFormat'=>'path',
                //'showScriptName' => false,
                'rules'=>array(
                    'post/<id:\d+>/<title:.*?>'=>'post/view',
                    'posts/<tag:.*?>'=>'post/index',
                    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    'gii'=>'gii',
                    'gii/<controller:\w+>'=>'gii/<controller>',
                    'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
                ),
            ),
            */
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                            'class'=>'CFileLogRoute',
                            'levels'=>'error, warning',
                    ),
                    // uncomment the following to show log messages on web pages

    //                array(
    //                        'class'=>'CWebLogRoute',
    //                ),
                    array( // configuration for the toolbar
                      'class'=>'XWebDebugRouter',
                      'config'=>'alignRight, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                      'levels'=>'error, warning, trace, profile, info',
                      //'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                     ),
                    ),
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
