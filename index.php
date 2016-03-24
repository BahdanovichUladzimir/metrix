<?php
date_default_timezone_set('Europe/Moscow');
$yii=dirname(__FILE__).'/../../lib/yii-1.1.17/framework/yiilite.php';

// change the following paths if necessary
if($_SERVER['HTTP_HOST']==='local.dev.all4holidays.com' || $_SERVER['HTTP_HOST']==='www.local.dev.all4holidays.com'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','local.dev');
    $yii=dirname(__FILE__).'/../../lib/yii-1.1.17/framework/yii.php';
}
elseif($_SERVER['HTTP_HOST']==='dev.all4holidays.com' || $_SERVER['HTTP_HOST']==='www.dev.all4holidays.com'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','dev');
    $yii=dirname(__FILE__).'/../../lib/yii-1.1.17/framework/yii.php';
}
elseif($_SERVER['HTTP_HOST']==='rc.all4holidays.com' || $_SERVER['HTTP_HOST']==='www.rc.all4holidays.com'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','rc');
}
elseif($_SERVER['HTTP_HOST']==='all4holidays.com' || $_SERVER['HTTP_HOST']==='www.all4holidays.com'){
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}
elseif($_SERVER['HTTP_HOST']==='local-holidays.ru' || $_SERVER['HTTP_HOST']==='www.local-holidays.ru'){
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','local.dev.mikhail');
    $yii=dirname(__FILE__).'/framework/yii.php';
}
// Иначе выключаем режим отладки и подключаем рабочую конфигурацию
else {
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}
/**bhd,kf**/
$config=dirname(__FILE__).'/protected/config/'.YII_ENV.'/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();
