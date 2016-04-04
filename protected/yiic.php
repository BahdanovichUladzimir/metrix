<?php

$yiic=dirname(__FILE__).'/../../lib/yii-1.1.17/framework/yiic.php';

if(strpos(dirname(__FILE__),'\domains\metrix')){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','local.dev');
    $yiic=dirname(__FILE__).'/../../../lib/yii-1.1.16/framework/yiic.php';


}
elseif(strpos(dirname(__FILE__),'home/metrixby/public_html')){
    error_reporting (E_ALL);
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
    defined('YII_ENV') or define('YII_ENV','production');
}
// Иначе выключаем режим отладки и подключаем рабочую конфигурацию
else {
    error_reporting (0);
    defined('YII_DEBUG') or define('YII_DEBUG',false);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
    defined('YII_ENV') or define('YII_ENV','production');
}
// change the following paths if necessary

$config=dirname(__FILE__).'/config/'.YII_ENV.'/console.php';
require_once($yiic);


