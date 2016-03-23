<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 08.07.2015
 */

class VkAuthWidget extends CWidget{

    public $view = 'default';
    public static $widgetId = 0;
    public $appId = NULL;
    public $scope = 'notify, friends, photos, audio, video, status, groups, email';
    public $redirectUri = NULL;
    public $apiVersion = '5.34';
    public $display = 'page';
    public $responseType = 'token';

    public function init(){
    }

    public function run(){
        if(is_null($this->appId) || is_null($this->redirectUri)){
            return false;
        }
        $this->render(
            $this->view,
            array(
                'widgetId' => self::$widgetId,
                'appId' => $this->appId,
                'scope' => $this->scope,
                'redirectUri' => $this->redirectUri,
                'apiVersion' => $this->apiVersion,
                'display' => $this->display,
                'responseType' => $this->responseType,
            )
        );
        self::$widgetId++;
    }
}