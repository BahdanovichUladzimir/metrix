<?php
date_default_timezone_set('Europe/Moscow');
$yii=dirname(__FILE__).'/../lib/yii-1.1.17/framework/yiilite.php';

// change the following paths if necessary
if($_SERVER['HTTP_HOST']==='metrix.loc' || $_SERVER['HTTP_HOST']==='www.metrix.loc'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','local.dev');
    $yii=dirname(__FILE__).'/../../lib/yii-1.1.17/framework/yii.php';
}
elseif($_SERVER['HTTP_HOST']==='dev.metrix.by' || $_SERVER['HTTP_HOST']==='www.dev.metrix.by'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','dev');
    $yii=dirname(__FILE__).'/../lib/yii-1.1.17/framework/yii.php';
}
elseif($_SERVER['HTTP_HOST']==='rc.metrix.by' || $_SERVER['HTTP_HOST']==='www.rc.metrix.by'){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','rc');
}
elseif($_SERVER['HTTP_HOST']==='metrix.by' || $_SERVER['HTTP_HOST']==='www.metrix.by'){
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}
// Иначе выключаем режим отладки и подключаем рабочую конфигурацию
else {
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','production');
}
/**bhd,kf**/
$config=dirname(__FILE__).'/protected/config/'.YII_ENV.'/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();
