<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 15.01.2015
 */

class DUrlRulesHelper {
    protected static $data = array();

    public static function import($moduleName)
    {
        if($moduleName && Yii::app()->hasModule($moduleName))
        {
            if (!isset(self::$data[$moduleName]))
            {
                $class = ucfirst($moduleName) . 'Module';
                Yii::import($moduleName . '.' . $class);
                if(method_exists($class, 'rules'))
                {
                    $urlManager = Yii::app()->getUrlManager();
                    $urlManager->addRules(call_user_func($class .'::rules'), false);
                }
                self::$data[$moduleName] = true;
            }
        }
    }
}