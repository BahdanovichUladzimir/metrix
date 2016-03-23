<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'tablePrefix' => '',
	'connectionString' => 'mysql:host=localhost;dbname=dev_dont_stop',
	'emulatePrepare' => true,
	'username' => /*'tolstiy'*/"root",
	'password' => "",//'656MGAuudF',
	'charset' => 'utf8',
	'schemaCachingDuration' => YII_DEBUG ? 0 : 3600,
);