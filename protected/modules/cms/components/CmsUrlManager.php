<?php

/**
 * CmsUrlManager class file.
 * @author Christoffer Niska <christoffer.niska@nordsoftware.com>
 * @copyright Copyright &copy; 2012, Nord Software Ltd
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package cms.components
 */

/**
 * URL manager that appends the application language to each URL to allow for multilingual URLs.
 */
class CmsUrlManager extends CUrlManager {

    public function init() {
        $this->_loadModuleUrls();
        parent::init();
    }

    /**
     * Constructs a URL.
     * @param string $route the controller and the action (e.g. article/read)
     * @param array $params list of GET parameters (name=>value).
     * @param string $ampersand the token separating name-value pairs in the URL. Defaults to '&'.
     * @return string the constructed URL
     * @see CUrlManager::createUrl
     */
    public function createUrl($route, $params = array(), $ampersand = '&') {
        /*if ((!isset($params['lang']) && (Yii::app()->language != 'ru')) || (Yii::app()->language == 'ru' && isset($params['lang'])))
            $params['lang'] = Yii::app()->language;*/
        $url = parent::createUrl($route, $params, $ampersand);
        return DMultilangHelper::addLangToUrl($url);

        //return parent::createUrl($route, $params, $ampersand);
    }

    protected function _loadModuleUrls() {
        $moduleDirs = array();
//        foreach(Yii::app()->modules as $m=>$key)array_push($moduleDirs, $m);
        array_push($moduleDirs, 'ads');
        array_push($moduleDirs, 'banner');
        array_push($moduleDirs, 'dating');
        array_push($moduleDirs, 'girl');
        array_push($moduleDirs, 'salon');
        array_push($moduleDirs, 'intimmap');
        array_push($moduleDirs, 'dating');

        $pattern = strtr(':fullPath/{:enabledModules}/config/routes.php', array(
            ':fullPath' => Yii::getPathOfAlias('application.modules'),
            ':enabledModules' => implode(',', $moduleDirs),
        ));
        $rulesUrl = Yii::app()->cache->get('rulesUrl');
        $expire = 86400 - 3600 * date("H") - 60 * date("i") - date("s");
        if ($rulesUrl === false):
            $rules = array();
            foreach (glob($pattern, GLOB_BRACE) as $route){
                $rules = array_merge(require($route), $rules);
            }
            Yii::app()->cache->set('rulesUrl', $rules, $expire);
            $rulesUrl = Yii::app()->cache->get('rulesUrl');
        endif;
        
        $this->rules = array_merge($rulesUrl,$this->rules);
    }

}
