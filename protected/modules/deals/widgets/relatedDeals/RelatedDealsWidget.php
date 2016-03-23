<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 11.04.2015
 * @var $category DealsCategories
 * @var $rating Ratings
 * @var $currentRatingsTotal UsersRatingsValues

 */

class RelatedDealsWidget extends CWidget{
    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public static $widgetId = 0;
    /**
     * @var Deals[]
     */
    public $relatedDeals = array();

    public function init(){
        if(sizeof($this->relatedDeals == 0)){
            $this->relatedDeals = $this->deal->getRelatedDeals();
        }
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        if(sizeof($this->deal->getRelatedDeals()) == 0){
            return false;
        }

        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'relatedDeals' => $this->relatedDeals,
                'widgetId' => self::$widgetId
            )
        );
        self::$widgetId++;
    }
}