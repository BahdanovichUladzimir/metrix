<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 22.09.2015
 */

class FbAuthWidget extends CWidget{

    public $view = 'default';
    public static $widgetId = 0;
    public $appId = NULL;
    public $scope = 'public_profile, email';
    public $fields = 'last_name,first_name,email,id,picture,name,link';
    public $redirectUrl = NULL;
    public $avatarWidth = 236;
    public $avatarHeight = 236;
    public $authUrl = '/fblogin';

    public function init(){
    }

    public function run(){
        if(is_null($this->appId)){
            return false;
        }
        $this->render(
            $this->view,
            array(
                'widgetId' => self::$widgetId,
                'appId' => $this->appId,
                'scope' => $this->scope,
                'fields' => $this->fields,
                'authUrl' => $this->authUrl,
                'redirectUrl' => $this->redirectUrl,
                'avatarWidth' => $this->avatarWidth,
                'avatarHeight' => $this->avatarHeight,
            )
        );
        self::$widgetId++;
    }
}