<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 */

class AuthenticateWidget extends CWidget{

    public static $widgetId;
    public $view = 'default';
    public function init(){
        self::$widgetId = 1;
    }

    public function run(){
        $model=new UserLogin;
        $this->render($this->view,
            array(
                'widgetId' => self::$widgetId,
                'model' => $model
            )
        );
        self::$widgetId++;
    }
}