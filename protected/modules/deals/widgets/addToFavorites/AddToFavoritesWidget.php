<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 */

class AddToFavoritesWidget extends CWidget{


    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'widgetId' => self::$widgetId
            )
        );
    }
}