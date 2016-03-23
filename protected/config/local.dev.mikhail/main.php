<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../main.php');
// наследуемся от main.php
return CMap::mergeArray($mainConfig, array(
	'name'=>'local.all4holidays.com',
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yiidebugtb.*', //our extension
	),
    'preload'=>array(
        'translate'
    ),
    'components' => array(
		'db'=>require(dirname(__FILE__).'/database.php'),
		/*'log'=>array(
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
					'allowedIPs'=>array('93.125.39.67'),
				),

				// uncomment the following to show log messages on web pages
				array(
					'class'=>'ext.db_profiler.DbProfileLogRoute',
					'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
					'slowQueryMin' => 0.01, // Minimum time for the query to be slow
				),
				array(
					'class'=>'CWebLogRoute',
				),
			),
		),*/
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

));
