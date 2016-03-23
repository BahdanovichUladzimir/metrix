<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.03.2015
 */

class DealCalendarWidget extends CWidget{

    /**
     * @var Deals
     */
    public $deal = NULL;
    public $view = 'default';
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }

        $this->render(
            $this->view,
            array(
                'deal' => $this->deal,
                'widgetId' => self::$widgetId,
            )
        );
    }
}