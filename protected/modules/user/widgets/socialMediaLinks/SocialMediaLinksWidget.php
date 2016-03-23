<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 19.04.2015
 */

class SocialMediaLinksWidget extends CWidget{

    /**
     * @var Deals
     */
    public $user = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
    }

    public function run(){
        if(is_null($this->user) || !($this->user instanceof User)){
            return false;
        }
        $this->render(
            $this->template,
            array(
                'user' => $this->user,
                'widgetId' => self::$widgetId
            )
        );
    }
}