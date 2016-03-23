<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

if($_SERVER['HTTP_HOST']==='dev.dont-stop.ru' || $_SERVER['HTTP_HOST']==='www.dev.dont-stop.ru'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','dev');
}
elseif($_SERVER['HTTP_HOST']==='rc.dont-stop.ru' || $_SERVER['HTTP_HOST']==='www.rc.dont-stop.ru'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','rc');
}
elseif($_SERVER['HTTP_HOST']==='dont-stop.ru' || $_SERVER['HTTP_HOST']==='www.dont-stop.ru'){
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}
// Иначе выключаем режим отладки и подключаем рабочую конфигурацию
else {
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}

$yii=dirname(__FILE__).'/../../lib/yii-1.1.16/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/'.YII_ENV.'/test.php';

require_once($yii);
Yii::createWebApplication($config)->run();
