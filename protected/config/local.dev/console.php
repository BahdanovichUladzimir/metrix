<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../console.php');
return CMap::mergeArray(
	$mainConfig,
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
		'name'=>'local.dev.all4holidays.com',
		'components'=>array(
			// database settings are configured in database.php
			'db'=>require(dirname(__FILE__).'/database.php'),
		),
	)
);
