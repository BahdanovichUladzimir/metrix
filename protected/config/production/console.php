<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../console.php');
// наследуемся от main.php
return CMap::mergeArray(
	$mainConfig,
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
		'name'=>'all4holidays.com',
		'components'=>array(
			// database settings are configured in database.php
			'db'=>require(dirname(__FILE__).'/database.php'),
		),
			'params'=>array(
				// this is used in contact page
					'adminEmail'=>'info@all4holidays.com',
				//'FromName'=>'Администрация сайта all4holidays',
					'fb' => array(
							'appId' => '1667215703554968',
					),
					'vk' => array(
							'groupId' => '92486833',
							'albumId' => '226241332',
							'appId' => '5206269',
							'secretKey' => '8zFkQIYoKFXsfOcTPTnS',
							//'accessToken' => '5fd11cd461b259e08e6bda7c136c89d0228a805dc6d45a8f5bdd214d89fcb3e6c197f3a7574a66d709335',
							'accessToken' => '43803a9d7094b9d5e7a786ff7ff2e81af0c55576ad4098399e9bba57a72bed64a79b4d4a0fe2f366c0c62',

					),
			),

	)
);
