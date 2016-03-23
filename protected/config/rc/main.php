<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../main.php');
// наследуемся от main.php
return CMap::mergeArray($mainConfig, array(
	'name'=>'rc.all4holidays.com',
	'components' => array(
		'db'=>require(dirname(__FILE__).'/database.php'),
	),
));
