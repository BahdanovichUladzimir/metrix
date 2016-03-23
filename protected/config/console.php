<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'all4holidays.com',
    'aliases' => array(
        'modules' => 'application.modules',
        'widgets' => 'application.widgets',
        'vendor' => 'application.vendor',
        'filters' => 'application.filters',
        'booster' => 'ext.yiibooster',
        'bootstrap' => 'booster',
        'xupload' => 'ext.xupload',
    ),
	// preloading 'log' component
	'preload'=>array('log'),
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
        'application.modules.email.*',
        'application.modules.email.models.*',
        'application.modules.email.components.*',
        'application.components.DUrlRulesHelper',
		'application.modules.payment.components.*',
		'application.modules.payment.models.*',
		'application.modules.cms.models.*',
		'application.helpers.*',
        'application.extensions.Yiippod.*',
        'filters.*'
    ),
	// application components
    'modules' => array(
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
            'registrationUrl' => array('/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery/recovery'),

            # login form path
            'loginUrl' => array('/login'),

            # page after login
            'returnUrl' => array('/user/profile/privateProfile'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
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
    ),
	'components'=>array(
        'user'=>array(
            'class'=>'RWebUser',
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'loginUrl'=>array('/login'),
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
		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'info, error, warning',
				),
                array(
                    'class'=>'CEmailLogRoute',
                    'levels'=>'error, warning',
                    'emails'=>'bahdanovich.uladzimir@gmail.com',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'trace, info',
                    'categories'=>'application.commands.dealPaidCommand.paymentForDealPriority',
                    'logFile' => 'paymentForDealPriority.log'
                ),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'info, error',
					'categories'=>'application.commands.socialMediaCommand.*',
					'logFile' => 'socialMediaCommands.log'
				),

            ),
		),
        'Smtpmail'=>array(
            'class'=>'ext.smtpmail.PHPMailer',
            'Host'=>"smtp.all4holidays.com",
            'Username'=>'info@all4holidays.com',
            'Password'=>'optCld1MWo',
            'Mailer'=>'smtp',
            'Port'=>465,
            'SMTPAuth'=>true,
            'SMTPSecure' => 'ssl',
            'CharSet'=>'utf-8'
        ),
        'config'=>array(
            'class'=>'DConfig',
            //'cache'=>3600,
        ),

	),

	'commandMap'=>array(
		'migrate'=>array(
			'class'=>'system.cli.commands.MigrateCommand',
			'migrationPath'=>'application.migrations',
			'migrationTable'=>'Migration',
			'connectionID'=>'db',
			//'templateFile'=>'application.migrations.template',
		),
    ),
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'info@all4holidays.com',
        //'FromName'=>'Администрация сайта all4holidays',
        'gmail' => array(
            'clientId' => '615933906465-ujhtd13knc1l5n3hcq26qkn4pg9d5vsc.apps.googleusercontent.com',
            'apiKey' => 'AIzaSyBzu73SWUapN6rw5el2MG1VGWjVh2IX_c4',
        ),
    ),

);
