<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'metrix.by',
    'homeUrl'=>array('/deals/frontend/catalog/index'),
    'defaultController' => 'deals/frontend/catalog/index',
    'behaviors'=> array(
		array(
			'class'=>'DModuleUrlRulesBehavior',
			'beforeCurrentModule'=>array(
				'admin',
				'rights',
				'user',
				'deals',
                'payment',
                'feedback'
			),
			'afterCurrentModule'=>array(
				'page',
			)
		)
	),
	'aliases' => array(
		'modules' => 'application.modules',
		'widgets' => 'application.widgets',
		'components' => 'application.components',
		'vendor' => 'application.vendor',
		'filters' => 'application.filters',
		'booster' => 'ext.yiibooster',
		'bootstrap' => 'booster',
		'xupload' => 'ext.xupload',
	),
	'theme'=>'main',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'booster',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',
		'application.modules.rights.*',
		'application.modules.rights.models.*',
        'application.modules.rights.components.*',
        'application.modules.admin.*',
        'application.modules.admin.models.*',
        'application.modules.admin.components.*',
		'application.modules.deals.*',
		'application.modules.deals.models.*',
		'application.modules.deals.components.*',
		'application.modules.events.*',
		'application.modules.events.models.*',
		'application.modules.events.components.*',
		'application.modules.comments.*',
		'application.modules.comments.models.*',
		'application.modules.comments.components.*',
		'application.modules.banners.*',
		'application.modules.banners.models.*',
		'application.modules.banners.components.*',
		'application.modules.feedback.*',
		'application.modules.feedback.models.*',
		'application.components.DUrlRulesHelper',
        'application.components.ImageHandler.CImageHandler',
		'application.modules.cms.CmsModule',
		'application.modules.cms.models.*',
		'application.modules.email.components.*',
		'application.modules.email.models.*',
		'application.modules.messages.components.*',
		'application.modules.messages.models.*',
		'application.modules.payment.components.*',
		'application.modules.payment.models.*',
		'application.modules.translate.components.*',
		'application.modules.translate.models.*',
		'application.helpers.*',
		'application.extensions.Yiippod.*',
        'filters.*',
        'application.modules.yiiseo.models.*','ext.eoauth.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'mju2716604',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','93.125.39.67',"79.98.54.145"),
			'generatorPaths' => array(
				'booster.gii'
			)
		),
		'user'=>array(
			'tableUsers' => 'Users',
			'tableProfiles' => 'Profiles',
			'tableProfileFields' => 'ProfilesFields',
			# encrypting method (php hash function)
			'hash' => 'md5',

			# send activation email
			'sendActivationMail' => false,

			# allow access for non-activated users
			'loginNotActiv' => true,

			# activate user on registration (only sendActivationMail = false)
			'activeAfterRegister' => true,

			# automatically login from registration
			'autoLogin' => true,

			# registration path
			'registrationUrl' => array('/user/registration/authorization'),

			# recovery password path
			'recoveryUrl' => array('/user/recovery/recovery'),

			# login form path
			'loginUrl' => array('/user/registration/authorization'),

			# page after login
			'returnUrl' => array('/user/profile/privateProfile'),

			# page after logout
			'returnLogoutUrl' => array('/user/registration/authorization'),
		),
		'rights' => array(
			'superuserName'=>'admin', // Name of the role with super user privileges.
			'authenticatedName'=>'Authenticated',  // Name of the authenticated user role.
			'userIdColumn'=>'id', // Name of the user id column in the database.
			'userNameColumn'=>'username',  // Name of the user name column in the database.
			'enableBizRule'=>true,  // Whether to enable authorization item business rules.
			'enableBizRuleData'=>true,   // Whether to enable data for business rules.
			'displayDescription'=>true,  // Whether to use item description instead of name.
			'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
			'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.

			'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested.
			'layout'=>'webroot.themes.main.views.rights.layouts.main',  // Layout to use for displaying Rights.
			'appLayout'=>'webroot.themes.main.views.layouts.backend', // Application layout.
			//'cssFile'=>'rights.css', // Style sheet file to use for Rights.
			'install'=>false,  // Whether to enable installer.
			'debug'=>false,
		),
		'admin',
		'deals',
        'feedback',
        'comments',
		'yiiseo'=>array(
            'class'=>'application.modules.yiiseo.YiiseoModule',
            //'password'=>'mju2716604',
        ),
		'cms',
        'email',
        'messages',
        'payment',
        'translate' => array(
            'languages' => array(
                'ru' => 'Russian',
                'de' => 'German'
            )
        ),
        'events',
		'banners'
	),

	// application components
	'components'=>array(
		'cms' => array(
			'class' => 'cms.components.Cms',
			'defaultLocale' => 'ru',
			'languages' => array('ru' => 'Русский'/*, 'en' => 'English','uk'=>'Український'*/),
			//'autoCreate' => false
		),
		/*'cache' => array(
			'class' => 'CFileCache',
		),*/
		'user'=>array(
			'class'=>'RWebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/user/registration/authorization'),
		),
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles'=>array('Guest'),
			'itemTable'=>'AuthItem',
			'itemChildTable'=>'AuthItemChild',
			'assignmentTable'=>'AuthAssignment',
			'rightsTable'=>'Rights',
		),
		'booster' => array(
			'class' => 'booster.components.Booster',
			'coreCss' => true,
            'responsiveCss' => true,
            'jqueryCss' => true,
            'yiiCss' => true,
            'enableJS' => false,
		),
		/*'Smtpmail'=>array(
			'class'=>'ext.smtpmail.PHPMailer',
			'Host'=>"smtp.all4holidays.com",
			'Username'=>'info@all4holidays.com',
			'Password'=>'optCld1MWo',
			'Mailer'=>'smtp',
			'Port'=>465,
			'SMTPAuth'=>true,
            'SMTPSecure' => 'ssl',
            'CharSet'=>'utf-8'
		),*/
		'messages' => array(
			'class' => 'CDbMessageSource',
            //'onMissingTranslation'  => array('CDbMessageTranslator', 'appendMessage'),
            // config for db message source here, see http://www.yiiframework.com/doc/api/CDbMessageSource
		),
		'image'=>array(
			'class'=>'ext.image.CImageComponent',
			// GD or ImageMagick
			'driver'=>'GD',
			// ImageMagick setup path
			'params'=>array('directory'=>'/opt/local/bin'),
		),
        'phpThumb'=>array(
            'class'=>'ext.EPhpThumb.EPhpThumb',
        ),
        'ih'=>array(
            'class'=>'CImageHandler',
        ),
        /*'search' => array(
            'class' => 'application.components.DGSphinxSearch',
            'server' => '127.0.0.1',
            'port' => 9313,
            'maxQueryTime' => 3000,
            'enableProfiling'=>0,
            'enableResultTrace'=>0,
            'fieldWeights' => array(
                'name' => 1000,
                'intro' => 500,
                'description' => 300,
            ),
        ),*/
        /*'session' => array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID'=>'db',
            'autoStart' => true,
            'sessionTableName'=>'Session',
            'useTransparentSessionID' => true,
            'timeout' => 60*60*24*7,
        ),*/


		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			//'urlSuffix' => '.html',
			//'caseSensitive' => false,
			'showScriptName'=>false,
			'rules'=>array(
				'/robots.txt' => "/robots/robots",
                array('sitemap/categoriesSiteMap', 'pattern'=>'categories_sitemap.xml', 'urlSuffix'=>''),
                array('sitemap/dealsSiteMap', 'pattern'=>'deals_sitemap_<cityKey:\w+>.xml', 'urlSuffix'=>''),
				//"deals_sitemap_<cityKey:cityKey>.xml"=>'sitemap/dealsSiteMap',
				'<name>-<id:\d+>.html' => 'cms/page/view',
				'/news' => '/site/news',
				'/articles' => '/site/articles',
				'<_a:\w+>/<id:\d+>'                   => '<_a>',
				'<_c:\w+>/<_a:\w+>/<id:\d+>'          => '<_c>/<_a>',
				'<_m:\w+>/<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_m>/<_c>/<_a>',

			),
		),
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'trace, info',
					'categories'=>'application.commands.dealPaidCommand.paymentForDealPriority',
                    'logFile' => 'paymentForDealPriority'
				),
				array(
						'class'=>'CFileLogRoute',
						'levels'=>'trace, info, error',
						'categories'=>'application.payments.webMoney.recharge',
						'logFile' => 'webmoney.log'
				),

				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'config'=>array(
			'class'=>'DConfig',
			//'cache'=>3600,
		),
        'seo'=>array(
            'class' => 'application.modules.yiiseo.components.SeoExt',
        ),
	),
	'sourceLanguage'=>'en',
	'language'=>'ru',

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'bahdanovich.uladzimir@gmail.com',
		//'FromName'=>'Администрация сайта metrix.by',
        'gmail' => array(
            'clientId' => '615933906465-ujhtd13knc1l5n3hcq26qkn4pg9d5vsc.apps.googleusercontent.com',
            'apiKey' => 'AIzaSyBzu73SWUapN6rw5el2MG1VGWjVh2IX_c4',
        ),
        'vk' => array(
            'appId' => '4863177',
            'secretKey' => 'BvwnJqMuCWQ5RkQDDSul',
			'accessToken' => '12a50043ee208440794b3c34931b7b249f000eceee21c57e4a1b011234dd62e8f686201af8b5631b41785',
        ),
        'webMoney' => array(
            'secretKey' => 'W8uYaoe3lWKIdDE4g3IF'
        ),
		'universalHash' => 'qN\YI29522W6.Ke'
	),
);
