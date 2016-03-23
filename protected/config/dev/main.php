<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../main.php');
// наследуемся от main.php
return CMap::mergeArray($mainConfig, array(
	'name'=>'dev.all4holidays.com',
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yiidebugtb.*', //our extension
        'application.extensions.NLSClientScript.*',

    ),
    'preload'=>array(
        'translate'
    ),
	'components' => array(
		/*'clientScript' => array(
			'class' => 'application.extensions.NLSClientScript.NLSClientScript',
			//'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
			//'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'

			'mergeJs' => true, //def:true
			'compressMergedJs' => true, //def:false

			'mergeCss' => true, //def:true
			'compressMergedCss' => true, //def:false

			'mergeJsExcludePattern' => '/edit_area/', //won't merge js files with matching names

			'mergeIfXhr' => true, //def:false, if true->attempts to merge the js files even if the request was xhr (if all other merging conditions are satisfied)

			'serverBaseUrl' => 'http://dev.all4holidays.com', //can be optionally set here
			'mergeAbove' => 1, //def:1, only "more than this value" files will be merged,
			'curlTimeOut' => 10, //def:10, see curl_setopt() doc
			'curlConnectionTimeOut' => 10, //def:10, see curl_setopt() doc

			'appVersion'=>1.0 //if set, it will be appended to the urls of the merged scripts/css
		),*/
		'db'=>require(dirname(__FILE__).'/database.php'),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array( // configuration for the toolbar
					'class'=>'XWebDebugRouter',
					'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('93.125.39.67','80.249.188.171','79.98.54.145'),
				),

				// uncomment the following to show log messages on web pages
				/*array(
					'class'=>'ext.db_profiler.DbProfileLogRoute',
					'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
					'slowQueryMin' => 0.01, // Minimum time for the query to be slow
				),*/
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),
        'search' => array(
            'class' => 'application.components.DGSphinxSearch',
            'server' => '127.0.0.1',
            'port' => 9312,
            'maxQueryTime' => 3000,
            'enableProfiling'=>0,
            'enableResultTrace'=>0,
            'fieldWeights' => array(
                'name' => 1000,
                'description' => 500,
            ),
        ),

        'messages' => array(
            'class' => 'CDbMessageSource',
            'onMissingTranslation' => array('Ei18n', 'missingTranslation'),
            // config for db message source here, see http://www.yiiframework.com/doc/api/CDbMessageSource
        ),
        'translate' => array(
            'class' => 'translate.components.Ei18n',
            'createTranslationTables' => true,
            'connectionID' => 'db',
            'languages' => array(
                'en' => 'English',
                //'es' => 'Español',
                //'it' => 'Italiano',
                'ru' => 'Russian'
            )
        ),
	),
    'modules'=>array(
        'translate'
    ),
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'info@all4holidays.com',
		//'FromName'=>'Администрация сайта all4holidays',
		'fb' => array(
			'appId' => '1667215703554968',
		),
        'vk' => array(
            'groupId' => '110115205',
            'albumId' => '225822888',
            'appId' => '4863177',
            'secretKey' => 'BvwnJqMuCWQ5RkQDDSul',
        ),
	),


));
