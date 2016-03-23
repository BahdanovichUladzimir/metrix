<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.04.2015
 */

class UserMenuWidget extends CWidget{

    public static $widgetId = 0;
    public $view = 'default';

    public function init(){
        //self::$widgetId = 1;
    }
    public function run(){
        $user = Yii::app()->user;
        if($user->isGuest){
            return false;
        }
        $dbUser = User::model()->findByPk($user->getId());
        $this->render($this->view,
            array(
                'widgetId' => self::$widgetId,
                'user' => $user,
                'dbUser' => $dbUser,
            )
        );
        self::$widgetId++;
    }
}