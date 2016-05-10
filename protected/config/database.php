<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'tablePrefix' => '',

	'connectionString' => 'mysql:host=localhost;dbname=metrixby_production',
	'emulatePrepare' => true,
	'username' => 'metrixby_admin',
	'password' => '-;X7$ScDzW6w',
	'charset' => 'utf8',
	'enableProfiling'=>true,
	'enableParamLogging' => true,
	'schemaCachingDuration' => YII_DEBUG ? 0 : 3600

);