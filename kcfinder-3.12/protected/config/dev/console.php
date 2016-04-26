<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$mainConfig = require(dirname(__FILE__).'/../console.php');
// наследуемся от main.php
return CMap::mergeArray(
	$mainConfig,
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..',
		'name'=>'dev.all4holidays.com',
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
                        'groupId' => '110115205',
                        'albumId' => '225822888',
                        'appId' => '4863177',
                        'secretKey' => 'BvwnJqMuCWQ5RkQDDSul',
						'accessToken' => 'c6dfbd47240f91d99ef049391241350b99ad9ab166079c8bce142d454970228072ffd318cbf4df4e1ef37',

				),
        ),
	)
);
