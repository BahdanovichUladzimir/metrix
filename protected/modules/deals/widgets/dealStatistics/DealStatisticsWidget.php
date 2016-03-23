<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 11.04.2015
 * @var $category DealsCategories
 * @var $rating Ratings
 * @var $currentRatingsTotal UsersRatingsValues

 */

class DealStatisticsWidget extends CWidget{
    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
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